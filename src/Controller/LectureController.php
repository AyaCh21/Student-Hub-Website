<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\StudyMaterial;
use App\Entity\Comment;
use App\Entity\Professor;
use App\Repository\RatingExamRepository;
use App\Repository\ProfessorRateRepository;
use App\Repository\ProfessorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CommentForm;
use App\Form\ReplyForm;
use App\Form\StudyMaterialType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Psr\Log\LoggerInterface;
use App\Service\PdfTextExtractor;
use App\Service\TextSummarizer;
use App\Service\SummaryPdfGenerator;
class LectureController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    #[Route("/lecture/{id}/{type}", name: "lecture")]
    public function lecture(int $id, string $type, EntityManagerInterface $entityManager,Request $request, RatingExamRepository $ratingExamRepository, ProfessorRateRepository $professorRateRepository,
                            ProfessorRepository $professorRepository, LabRateRepository $labRateRepository, LabInstructorRateRepository $labInstructorRateRepository): Response
    {
        // Fetch the course name
        $course = $entityManager->getRepository(Course::class)->find($id);
        $courseName = $course ? $course->getName() : 'Unknown Course';

        // Fetch professor based on course ID
        $professor = $professorRepository->findProfessorByCourseId($id);
        $professorName = $professor ? $professor->getName() : 'Unknown Professor';
        // Fetch average professor rating
        $averageProfessorRating = $professor ? $professorRateRepository->getAverageRatingForProfessor($professor->getId()) : null;

        $studyMaterials = $entityManager->getRepository(StudyMaterial::class)->findBy([
            'course' => $id,
            'type' => $type
        ]);

        $comments = $entityManager->getRepository(Comment::class)->findBy([
            'course_id' => $id,
            'type' => $type,
        ]);

        $this->stylesheets[] = 'lecture.css';
        $this->javascripts[] = 'lecture.js';

        $comment = new Comment();
        $commentForm = $this->createForm(CommentForm::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCourseId($id);
            $comment->setUserId($this->getUser()->getId());
            $comment->setType($type);
            $comment->setCreatedAt(new \DateTime());
            $comment->setUpdatedAt(new \DateTime());

            $parentId = $request->request->get('parent_id');
            if ($parentId) {
                $parentComment = $entityManager->getRepository(Comment::class)->find($parentId);
                if ($parentComment && $parentComment->getParent() === null) {
                    $comment->setParent($parentComment);
                } else {
                    throw new \Exception('You can only reply to top-level comments.');
                }
            }
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('lecture', ['id' => $id, 'type' => $type]);
        }

        $replyComment = new Comment();
        $replyForm = $this->createForm(ReplyForm::class, $comment);
        $replyForm->handleRequest($request);

        if ($replyForm->isSubmitted() && $replyForm->isValid()) {
            $replyComment->setCourseId($id);
            $replyComment->setUserId($this->getUser()->getId());
            $replyComment->setType($type);
            $replyComment->setCreatedAt(new \DateTime());
            $replyComment->setUpdatedAt(new \DateTime());

            $parentId = $request->request->get('parent_id');
            if ($parentId) {
                $parentComment = $entityManager->getRepository(Comment::class)->find($parentId);
                if ($parentComment) {
                    $replyComment->setParent($parentComment);
                }
            }

            $entityManager->persist($replyComment);
            $entityManager->flush();

            return $this->redirectToRoute('lecture', ['id' => $id, 'type' => $type]);
        }

        $studyMaterial = new StudyMaterial();
        $studyMaterial->setCourse($entityManager->getRepository(Course::class)->find($id));
        $studyMaterial->setType($type);

        $form = $this->createForm(StudyMaterialType::class, $studyMaterial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('test_pdf')->getData();

            if ($file) {
                $pdfData = file_get_contents($file->getPathname());
                $studyMaterial->setTestPdf($pdfData);
            }

            $studyMaterial->setText($form->get('text')->getData());

            $entityManager->persist($studyMaterial);
            $entityManager->flush();

            return $this->redirectToRoute('lecture', [
                'id' => $id,
                'type' => $type
            ]);
        }
        // Fetch average course rating (this is actual an exam rating)
        $averageCourseRating = $ratingExamRepository->getAverageRatingForCourse($id);



        // Fetch lab instructors and their average ratings
        $labInstructors = $course->getLabInstructors();  // This returns a collection of LabInstructor
        $labInstructorRatings = [];
        $labInstructorNames = [];  // Initialize an array to store lab instructor names

        foreach ($labInstructors as $labInstructor) {
            $labInstructorRatings[] = [
                'labInstructor' => $labInstructor,
                'averageRating' => $labInstructorRateRepository->getAverageRatingForLabInstructor($labInstructor->getId())
            ];
            $labInstructorNames[] = $labInstructor->getName();  // Add the name to the array
        }


        $averageLabRating = $labRateRepository->getAverageRatingForLab($id);

        // Fetch average professor rating
        //$averageProfessorRating = $professor ? $professorRateRepository->getAverageRatingForProfessor($professor->getId()) : null;


        return $this->render('lecture.html.twig', [
            'studyMaterials' => $studyMaterials,
            'type' => ucfirst($type),  // Capitalize the first letter of the type for display
            'courseName' => $courseName,  // Pass the course name to the template
            'course' => $course,
            'comments' => $comments,
            'commentForm' => $commentForm->createView(),
            'replyForm' => $replyForm->createView(),
            'stylesheets' => $this->stylesheets,
            'javascripts' => $this->javascripts,
            'averageCourseRating' => $averageCourseRating,
            'averageProfessorRating' => $averageProfessorRating,
            'professorName' => $professorName,
            'professor' => $professor,
            'form' => $form->createView(),
            'averageLabRating' => $averageLabRating,
            'labInstructorName' => $labInstructorNames,  // Pass the array of names to the view
            'labInstructor' => $labInstructors,  // Pass the collection of lab instructors
            'labInstructorRatings' => $labInstructorRatings,  // Pass this variable to the view

        ]);
    }
    #[Route('/generate_summary', name: 'generate_summary')]
    public function generateSummary(Request $request, EntityManagerInterface $entityManager, PdfTextExtractor $pdfTextExtractor, TextSummarizer $textSummarizer, SummaryPdfGenerator $summaryPdfGenerator): Response
    {
        $data = json_decode($request->getContent(), true);
        $pdfId = $data['pdf_id'];

        $studyMaterial = $entityManager->getRepository(StudyMaterial::class)->find($pdfId);
        if (!$studyMaterial) {
            return new Response('Material not found', 404);
        }

        $outputPath = sys_get_temp_dir() . '/summary.pdf';
        $pages = [];

        // Check if the study material has a file path or a blob
        if ($studyMaterial->getFilePath()) {
            $pdfPath = $studyMaterial->getFilePath();
            $pages = $pdfTextExtractor->extractTextFromPath($pdfPath);
        } elseif ($studyMaterial->getTestPdf()) {
            $pdfBlob = stream_get_contents($studyMaterial->getTestPdf());
            $pages = $pdfTextExtractor->extractTextFromBlob($pdfBlob);
        }

        // Check if the extracted text is empty or incomplete
        if (empty($pages)) {
            return new Response('Failed to extract text from PDF', 500);
        }

        // Summarize text using the existing summarizer
        $summary = $textSummarizer->summarize($pages);

        // Generate summary PDF
        $summaryPdfGenerator->generate($summary, $outputPath);

        $response = new BinaryFileResponse($outputPath);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'summary.pdf');
        return $response;
    }
    #[Route('/study_material/{id}/view_pdf', name: 'view_pdf')]
    public function viewPdf(int $id, EntityManagerInterface $entityManager): Response {
        $studyMaterial = $entityManager->getRepository(StudyMaterial::class)->find($id);

        if (!$studyMaterial || !$studyMaterial->getTestPdf()) {
            throw $this->createNotFoundException('The PDF does not exist');
        }

        $response = new Response(stream_get_contents($studyMaterial->getTestPdf()));
        $response->headers->set('Content-Type', 'application/pdf');
        return $response;
    }
}
