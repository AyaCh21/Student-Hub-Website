<?php
namespace App\Controller;

use App\Entity\Course;
use App\Entity\Professor;
use App\Entity\ProfessorRate;
use App\Entity\rating_exam;
use App\Entity\Student;
use App\Form\RatingType;
use App\Repository\CourseRepository;
use App\Repository\RatingExamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RatingController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private array $stylesheets;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/rate_course", name="course_rate")
     */
    public function addCourseRate(Request $request): Response
    {
        $rating = new rating_exam(); // Instantiate rating_exam without constructor parameters

        $form = $this->createForm(RatingType::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the rate_value property from the form data
            $rating->setRateValue($form->get('rate_value')->getData());

            // Assuming you have access to course and student IDs
            $courseId = $form->get('course_id')->getData();; // Replace with the actual course ID
            $studentId = 1; // Replace with the actual student ID

            // Set the course and student IDs
            $rating->setCourseId($courseId);
            $rating->setStudentId($studentId);

            // Persist the rating to the database
            $this->entityManager->persist($rating);
            $this->entityManager->flush();

            // Flash message for success
            $this->addFlash('success', 'Thank you for rating the course!');

            // Redirect to the homepage or any other page after successful submission
            return $this->redirectToRoute('display_ratings');
        }

        // Render the form
        return $this->render('rate_course.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/display_rate_course", name="display_course_rate")
     */
    public function viewCourseRate(RatingExamRepository $ratingRepository, CourseRepository $courseRepository): Response
    {
        // Get average ratings for each course
        $averageRatings = $ratingRepository->getAverageRatings();

        // Fetch course names based on course IDs
        $courseNames = [];
        foreach ($averageRatings as $courseId => $ratingData) {
            $courseNames[$courseId] = $courseRepository->find($courseId)->getName();
        }

        // Render the ratings display page
        return $this->render('display_ratings.html.twig', [
            'averageRatings' => $averageRatings,
            'courseNames' => $courseNames,
        ]);
    }

    #[\Symfony\Component\Routing\Attribute\Route("/rate_prof", name:"professor_rate")]
    public function addProfRate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $professor_rate = new ProfessorRate();
        $professors = $entityManager->getRepository(Professor::class)->findAll();

        $form = $this->createFormBuilder($professor_rate)
            ->add('professor',ChoiceType::class,[
                'choices'=>$professors,
                'choice_label'=>function (Professor $professor) {
                    return $professor->getName(); // Assuming getName() exists
                },
                'placeholder' => '-- Select Professor --',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please select a professor.',
                    ]),
                ],
                'label' => 'choose the professor:'
            ])
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => function (Student $student) {
                    return $student->getId();
                },
            ])
            ->add('rate',RangeType::class,[
                'attr' => ['min' => 0, 'max' => 10],
                'label' => 'choose the rate:'
            ])
            ->add('save',SubmitType::class,['label'=>'submit rate'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $studentId = $form->get('student')->getData();
            $student = $entityManager->getRepository(Student::class)->find($studentId);
            if (!$student) {
                echo "Student not found.";
            } else {
                $professor_rate->setStudent($student);
            }

            $rate = $form->get('rate')->getData();
            $professor_rate->setRate($rate);

            $entityManager->persist($professor_rate);
            $entityManager->flush();
            return $this->redirectToRoute('study');
        }

        $this->stylesheets[]='rate_form.css';
        $this->scripts[]='rate_range_prof.js';

        return $this->render('rate_professor.html.twig',[
            'form_rate_prof' => $form->createView(),
            'stylesheets'=>$this->stylesheets,
            'scripts'=>$this->scripts
        ]);
    }

    #[Route("/display_rate_prof", name:"display_professor_rate")]
    public function viewProfRate(EntityManagerInterface $entityManager): Response
    {
        $courses = $entityManager->getRepository(Course::class)->findAll();
        $professorWiseCourses = [];
        $professorRatings = [];
        $professorVotes = [];

        foreach ($courses as $course) {
            $professor = $course->getProfessor();
            $professorName = $professor->getName();
            if (!isset($professorWiseCourses[$professorName])) {
                $professorWiseCourses[$professorName] = [];
            }
            $professorWiseCourses[$professorName][] = $course;
        }

        $professors = $entityManager->getRepository(Professor::class)->findAll();

        foreach ($professors as $professor) {
            $rates = $entityManager->getRepository(ProfessorRate::class)->findBy(['professor' => $professor]);
            $totalRate = array_reduce($rates, function ($sum, $rate) {
                return $sum + $rate->getRate();
            }, 0);

            $averageRate = count($rates) > 0 ? $totalRate / count($rates) : 0;
            $professorRatings[$professor->getName()] = $averageRate;
            $professorVotes[$professor->getName()] = count($rates);
        }

        $this->stylesheets[] = 'rate_form.css';
        $this->scripts[] = '';

        return $this->render('display_rate_professor.html.twig', [
            'stylesheets' => $this->stylesheets,
            'professorWiseCourses' => $professorWiseCourses,
            'professorRatings' => $professorRatings,
            'professorVotes' => $professorVotes,
            'scripts' => $this->scripts
        ]);
    }
}
