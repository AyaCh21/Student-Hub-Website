<?php
namespace App\Controller;

use App\Entity\Course;
use App\Entity\Professor;
use App\Entity\ProfessorRate;
use App\Entity\ExamRate;
use App\Entity\Student;
use App\Form\ProfessorRateForm;
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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use App\Entity\LabRate;
use App\Entity\LabInstructor;
use App\Entity\LabInstructorRate;
use App\Form\LabRateForm;
use App\Form\LabInstructorRateForm;

#[AllowDynamicProperties] class RatingController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private array $stylesheets;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function setFormFactory(FormFactoryInterface $formFactory): void
    {
        $this->formFactory = $formFactory;
    }
    /**
     * @Route("/rate_course", name="course_rate")
     */
    public function rateCourse(Request $request): Response
    {
        $rating = new examRate(); // Instantiate examRate without constructor parameters

        $form = $this->createForm(RatingType::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the rate_value property from the form data
            $rating->setRateValue($form->get('rate_value')->getData());

            // Assuming you have access to course and student IDs
            $courseId = $form->get('course_id')->getData(); // Replace with the actual course ID
            $user = $this->security->getUser();
            if($user===null){
            $this->stylesheets[]='login.css';
            return $this->render('login.html.twig', [
                'stylesheets'=>$this->stylesheets
            ]);
        }
            $studentId = $user->getID(); // Replace with the actual student ID

            // Set the course and student IDs
            $rating->setCourseId($courseId);
            $rating->setStudentId($studentId);

            // Persist the rating to the database
            $this->entityManager->persist($rating);
            $this->entityManager->flush();

            // Flash message for success
            $this->addFlash('success', 'Thank you for rating the course!');

            // Redirect to the homepage or any other page after successful submission
            return $this->redirectToRoute('display_course_rate');
        }

        $this->stylesheets[]='rate_form.css';

        // Render the form
        return $this->render('rate_course.html.twig', [
            'form' => $form->createView(),
            'stylesheets'=>$this->stylesheets,

        ]);
    }

    #[Route("/rate_this_exam", name: "rate_this_exam")]
    public function rateThisExam(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $courseId = $request->query->get('courseId');
        $type = $request->query->get('type');

        if (!$courseId) {
            throw $this->createNotFoundException('Course ID is missing');
        }

        $course = $entityManager->getRepository(Course::class)->find($courseId);

        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }

        $user = $security->getUser();
        if (!$user) {
            $this->addFlash('warning', 'You need to log in to rate the course.');
            return $this->redirectToRoute('login');
        }

        $existingRating = $entityManager->getRepository(ExamRate::class)
            ->findOneBy(['course' => $course, 'student' => $user]);

        /*if ($existingRating) {
            $this->addFlash('warning', 'You have already rated this exam.');
            return $this->redirectToRoute('lecture', ['id' => $courseId, 'type' => $request->query->get('type')]);
        }*/

        $rating = new ExamRate();
        $rating->setCourse($course);
        $rating->setStudent($user);

        $form = $this->createForm(RatingType::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rating);
            $entityManager->flush();

            $this->addFlash('success', 'Thank you for rating this exam!');
            return $this->redirectToRoute('lecture', ['id' => $courseId, 'type' => $type]);
        }

        return $this->render('rate_this_exam.html.twig', [
            'form' => $form->createView(),
            'course' => $course,
            'type' => $type
        ]);
    }

    #[Route('/rate_professor', name: 'rate_professor')]
    public function rateProfessor(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $professorId = $request->query->get('professorId');
        $type = $request->query->get('type');
        $courseId = $request->query->get('courseId');
        $course = $entityManager->getRepository(Course::class)->find($courseId);

        if (!$professorId) {
            throw $this->createNotFoundException('Professor ID is missing');
        }

        $professor = $entityManager->getRepository(Professor::class)->find($professorId);

        if (!$professor) {
            throw $this->createNotFoundException('Professor not found');
        }

        $user = $security->getUser();
        if (!$user) {
            $this->addFlash('warning', 'You need to log in to rate the professor.');
            return $this->redirectToRoute('login');
        }

        $existingRating = $entityManager->getRepository(ProfessorRate::class)
            ->findOneBy(['professor' => $professor, 'student' => $user]);

        $rating = new ProfessorRate();
        $rating->setProfessor($professor);
        $rating->setStudent($user);

        $form = $this->createForm(ProfessorRateForm::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rating);
            $entityManager->flush();

            $this->addFlash('success', 'Thank you for rating this professor!');
            return $this->redirectToRoute('lecture', ['id' => $courseId, 'type' => $type]);
        }

        return $this->render('rate_professor.html.twig', [
            'form' => $form->createView(),
            'professor' => $professor,
            'type' => $type
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

        $this->stylesheets[]='rate_form.css';

        // Render the ratings display page
        return $this->render('display_rate_course.html.twig', [
            'averageRatings' => $averageRatings,
            'courseNames' => $courseNames,
            'stylesheets'=>$this->stylesheets,
        ]);
    }

    #[Route("/rate_prof/{professorId}", name:"professor_rate")]
    public function addProfRate(int $professorId,Request $request, EntityManagerInterface $entityManager, AuthenticationUtils $authenticationUtils,UserPasswordHasherInterface $passwordHasher): Response
    {
        $professor_rate = new ProfessorRate();
        $professors = $entityManager->getRepository(Professor::class)->find($professorId);
        if (!$professors) {
            throw $this->createNotFoundException('Professor not found');
        }
        $form = $this->createForm(ProfessorRateForm::class, $professor_rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentUsername = $form->get('studentUsername')->getData();
            $student = $entityManager->getRepository(Student::class)->findOneBy(['username' => $studentUsername]);
            if (!$student) {
                throw $this->createNotFoundException('Student not found');
            }
            $professor_rate ->setStudent($student);
            $professor_rate ->setProfessor($professors);
            $rate = $form->get('rate')->getData();
            $professor_rate->setRate($rate);

            $entityManager->persist($professor_rate);
            $entityManager->flush();
            return $this->redirectToRoute('display_professor_rate');
        }
        $student = $this->security->getUser();
        $this->stylesheets[]='rate_form.css';
        $this->scripts[]='rate_range_prof.js';

        return $this->render('rate_professor.html.twig',[
            'professor' => $professors,
            'student'=>$student,
            'form_rate_prof' => $form->createView(),
            'stylesheets'=>$this->stylesheets,
            'scripts'=>$this->scripts
        ]);
    }

    #[Route("/display_rate_prof", name: "display_professor_rate")]
    public function viewProfRate(EntityManagerInterface $entityManager,AuthenticationUtils $authenticationUtils): Response
    {
        $courses = $entityManager->getRepository(Course::class)->findAll();
        $professorWiseCourses = [];
        $professorRatings = [];
        $professorVotes = [];

        foreach ($courses as $course) {
            $professor = $course->getProfessor();
            if (!isset($professorWiseCourses[$professor->getId()])) {
                $professorWiseCourses[$professor->getId()] = [
                    'professor' => $professor,
                    'courses' => []
                ];
            }
            $professorWiseCourses[$professor->getId()]['courses'][] = $course;
        }

        $professors = $entityManager->getRepository(Professor::class)->findAll();

        foreach ($professors as $professor) {
            $rates = $entityManager->getRepository(ProfessorRate::class)->findBy(['professor' => $professor]);
            $totalRate = array_reduce($rates, function ($sum, $rate) {
                return $sum + $rate->getRate();
            }, 0);

            $averageRate = count($rates) > 0 ? $totalRate / count($rates) : 0;
            $professorRatings[$professor->getId()] = $averageRate;
            $professorVotes[$professor->getId()] = count($rates);
        }

        $student = $this->security->getUser();
        $stylesheets = ['rate_form.css'];
        $scripts = [];

        return $this->render('display_rate_professor.html.twig', [
            'stylesheets' => $stylesheets,
            'professorWiseCourses' => $professorWiseCourses,
            'professorRatings' => $professorRatings,
            'professorVotes' => $professorVotes,
            'scripts' => $scripts,
            'student' => $student
        ]);
    }

    // for type = "lab" specific stuff :
    #[Route('/rate_lab', name: 'rate_lab')]
    public function rateLab(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $courseId = $request->query->get('courseId');
        $type = $request->query->get('type');

        if (!$courseId) {
            throw $this->createNotFoundException('Course ID is missing');
        }

        $course = $entityManager->getRepository(Course::class)->find($courseId);

        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }

        $user = $security->getUser();
        if (!$user) {
            $this->addFlash('warning', 'You need to log in to rate the lab.');
            return $this->redirectToRoute('login');
        }

        $existingRating = $entityManager->getRepository(LabRate::class)
            ->findOneBy(['course' => $course, 'student' => $user]);

        $rating = new LabRate();
        $rating->setCourse($course);
        $rating->setStudent($user);

        $form = $this->createForm(LabRateForm::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rating);
            $entityManager->flush();

            $this->addFlash('success', 'Thank you for rating this lab!');
            return $this->redirectToRoute('lecture', ['id' => $courseId, 'type' => $type]);
        }

        return $this->render('rate_lab.html.twig', [
            'form' => $form->createView(),
            'course' => $course,
            'type' => $type
        ]);
    }

    #[Route('/rate_lab_instructor', name: 'rate_lab_instructor')]
    public function rateLabInstructor(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $labInstructorId = $request->query->get('labInstructorId');
        $type = $request->query->get('type');
        $courseId = $request->query->get('courseId');

        if (!$labInstructorId) {
            throw $this->createNotFoundException('Lab Instructor ID is missing');
        }

        $labInstructor = $entityManager->getRepository(LabInstructor::class)->find($labInstructorId);

        if (!$labInstructor) {
            throw $this->createNotFoundException('Lab Instructor not found');
        }

        $user = $security->getUser();
        if (!$user) {
            $this->addFlash('warning', 'You need to log in to rate the lab instructor.');
            return $this->redirectToRoute('login');
        }

        $existingRating = $entityManager->getRepository(LabInstructorRate::class)
            ->findOneBy(['labInstructor' => $labInstructor, 'student' => $user]);

        $rating = new LabInstructorRate();
        $rating->setLabInstructor($labInstructor);
        $rating->setStudent($user);

        $form = $this->createForm(LabInstructorRateForm::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rating);
            $entityManager->flush();

            $this->addFlash('success', 'Thank you for rating this lab instructor!');
            return $this->redirectToRoute('lecture', ['id' => $courseId, 'type' => $type]);
        }

        return $this->render('rate_lab_instructor.html.twig', [
            'form' => $form->createView(),
            'labInstructor' => $labInstructor,
            'type' => $type
        ]);
    }


}
