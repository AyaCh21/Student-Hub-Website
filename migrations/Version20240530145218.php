<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530145218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        /*$this->addSql('ALTER TABLE Comment DROP FOREIGN KEY Comment_ibfk_1');
        $this->addSql('ALTER TABLE Comment DROP FOREIGN KEY Comment_ibfk_2');
        $this->addSql('DROP INDEX user_id ON Comment');
        $this->addSql('DROP INDEX course_id ON Comment');
        $this->addSql('ALTER TABLE Comment CHANGE type type VARCHAR(10) NOT NULL, CHANGE comment_text comment_text LONGTEXT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Comment RENAME INDEX parent_id TO IDX_5BC96BF0727ACA70');
        $this->addSql('ALTER TABLE Favorite CHANGE StudentID StudentID INT NOT NULL, CHANGE CourseID CourseID INT NOT NULL');
        $this->addSql('ALTER TABLE Favorite ADD CONSTRAINT FK_91B3EC8F21208DF3 FOREIGN KEY (StudentID) REFERENCES Student (id)');
        $this->addSql('ALTER TABLE Favorite ADD CONSTRAINT FK_91B3EC8FAF7ECA FOREIGN KEY (CourseID) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_91B3EC8F21208DF3 ON Favorite (StudentID)');
        $this->addSql('CREATE INDEX IDX_91B3EC8FAF7ECA ON Favorite (CourseID)');
        $this->addSql('ALTER TABLE Feedback CHANGE course_id course_id INT NOT NULL, CHANGE student_id student_id INT NOT NULL, CHANGE feedback feedback LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE Feedback RENAME INDEX course_id TO IDX_2B5F260E591CC992');
        $this->addSql('ALTER TABLE Feedback RENAME INDEX student_id TO IDX_2B5F260ECB944F1A');
        $this->addSql('ALTER TABLE Feedbackprof CHANGE student_id student_id INT NOT NULL, CHANGE professor_id professor_id INT NOT NULL, CHANGE feedback feedback LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE Feedbackprof RENAME INDEX student_id TO IDX_163A8501CB944F1A');
        $this->addSql('ALTER TABLE Feedbackprof RENAME INDEX professor_id TO IDX_163A85017D2D84D5');
        $this->addSql('DROP INDEX name_UNIQUE ON Professor');
        $this->addSql('ALTER TABLE Professor CHANGE name name VARCHAR(70) NOT NULL');
        $this->addSql('ALTER TABLE Student CHANGE username username VARCHAR(120) NOT NULL, CHANGE email email VARCHAR(60) NOT NULL, CHANGE password password VARCHAR(20) NOT NULL, CHANGE phase phase INT NOT NULL, CHANGE specialisation specialisation VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE StudyMaterial CHANGE uploaded_by uploaded_by INT NOT NULL, CHANGE course_id course_id INT NOT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE file_type file_type VARCHAR(50) NOT NULL, CHANGE file_path file_path VARCHAR(255) NOT NULL, CHANGE text text LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE StudyMaterial RENAME INDEX uploaded_by TO IDX_77EB4029E3E73126');
        $this->addSql('ALTER TABLE StudyMaterial RENAME INDEX course_id TO IDX_77EB4029591CC992');
        $this->addSql('DROP INDEX name_UNIQUE ON course');
        $this->addSql('ALTER TABLE course CHANGE professor_id professor_id INT NOT NULL, CHANGE name name TINYTEXT NOT NULL, CHANGE semester semester INT NOT NULL, CHANGE specialisation specialisation TINYTEXT NOT NULL, CHANGE ects ects INT NOT NULL');
        $this->addSql('ALTER TABLE course RENAME INDEX professor_id TO IDX_169E6FB97D2D84D5');
        $this->addSql('ALTER TABLE course_lab_instructor DROP FOREIGN KEY course_lab_instructor_ibfk_2');
        $this->addSql('ALTER TABLE course_lab_instructor DROP FOREIGN KEY course_lab_instructor_ibfk_1');
        $this->addSql('ALTER TABLE course_lab_instructor ADD CONSTRAINT FK_A66373F2591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_lab_instructor ADD CONSTRAINT FK_A66373F2A027DEFC FOREIGN KEY (lab_instructor_id) REFERENCES LabInstructor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_lab_instructor RENAME INDEX lab_instructor_id TO IDX_A66373F2A027DEFC');
        $this->addSql('ALTER TABLE ratingExam RENAME INDEX course_id TO IDX_CC3B2DFB591CC992');
        $this->addSql('ALTER TABLE ratingExam RENAME INDEX student_id TO IDX_CC3B2DFBCB944F1A');
        $this->addSql('ALTER TABLE ratingLab CHANGE course_id course_id INT DEFAULT NULL, CHANGE student_id student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ratingLab RENAME INDEX fk_ratinglab_course TO IDX_35E8DDD2591CC992');
        $this->addSql('ALTER TABLE ratingLab RENAME INDEX fk_ratinglab_student TO IDX_35E8DDD2CB944F1A');
        $this->addSql('ALTER TABLE ratingLabInstructor CHANGE lab_instructor_id lab_instructor_id INT DEFAULT NULL, CHANGE student_id student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ratingLabInstructor RENAME INDEX fk_ratinglabinstructor_labinstructor TO IDX_6A630D36A027DEFC');
        $this->addSql('ALTER TABLE ratingLabInstructor RENAME INDEX fk_ratinglabinstructor_student TO IDX_6A630D36CB944F1A');
        $this->addSql('ALTER TABLE ratingProf CHANGE student_id student_id INT NOT NULL, CHANGE rate_value rate_value INT NOT NULL');
        $this->addSql('ALTER TABLE ratingProf RENAME INDEX professor_id TO IDX_AF3AFB867D2D84D5');
        $this->addSql('ALTER TABLE ratingProf RENAME INDEX student_id TO IDX_AF3AFB86CB944F1A');
        $this->addSql('ALTER TABLE reset_password_request DROP updated_at, CHANGE expires_at expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE selector selector VARCHAR(20) NOT NULL, CHANGE hashed_token hashed_token VARCHAR(100) NOT NULL, CHANGE requested_at requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reset_password_request RENAME INDEX user_id TO IDX_7CE748AA76ED395');*/
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        /*$this->addSql('ALTER TABLE ratingLab CHANGE course_id course_id INT NOT NULL, CHANGE student_id student_id INT NOT NULL');
        $this->addSql('ALTER TABLE ratingLab RENAME INDEX idx_35e8ddd2591cc992 TO FK_ratingLab_course');
        $this->addSql('ALTER TABLE ratingLab RENAME INDEX idx_35e8ddd2cb944f1a TO FK_ratingLab_student');
        $this->addSql('ALTER TABLE Feedbackprof CHANGE student_id student_id INT DEFAULT NULL, CHANGE professor_id professor_id INT DEFAULT NULL, CHANGE feedback feedback TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE Feedbackprof RENAME INDEX idx_163a8501cb944f1a TO student_id');
        $this->addSql('ALTER TABLE Feedbackprof RENAME INDEX idx_163a85017d2d84d5 TO professor_id');
        $this->addSql('ALTER TABLE Professor CHANGE name name VARCHAR(100) DEFAULT NULL');*/
        $this->addSql('CREATE UNIQUE INDEX name_UNIQUE ON Professor (name)');
        /*$this->addSql('ALTER TABLE Feedback CHANGE student_id student_id INT DEFAULT NULL, CHANGE course_id course_id INT DEFAULT NULL, CHANGE feedback feedback TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE Feedback RENAME INDEX idx_2b5f260e591cc992 TO course_id');
        $this->addSql('ALTER TABLE Feedback RENAME INDEX idx_2b5f260ecb944f1a TO student_id');
        $this->addSql('ALTER TABLE course CHANGE professor_id professor_id INT DEFAULT NULL, CHANGE name name VARCHAR(200) DEFAULT NULL, CHANGE semester semester INT DEFAULT NULL, CHANGE specialisation specialisation VARCHAR(40) DEFAULT NULL, CHANGE ects ects INT DEFAULT NULL');*/
        $this->addSql('CREATE UNIQUE INDEX name_UNIQUE ON course (name)');
        /*$this->addSql('ALTER TABLE course RENAME INDEX idx_169e6fb97d2d84d5 TO professor_id');
        $this->addSql('ALTER TABLE ratingExam RENAME INDEX idx_cc3b2dfb591cc992 TO course_id');
        $this->addSql('ALTER TABLE ratingExam RENAME INDEX idx_cc3b2dfbcb944f1a TO student_id');
        $this->addSql('ALTER TABLE course_lab_instructor DROP FOREIGN KEY FK_A66373F2591CC992');
        $this->addSql('ALTER TABLE course_lab_instructor DROP FOREIGN KEY FK_A66373F2A027DEFC');*/
        $this->addSql('ALTER TABLE course_lab_instructor ADD CONSTRAINT course_lab_instructor_ibfk_2 FOREIGN KEY (lab_instructor_id) REFERENCES LabInstructor (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE course_lab_instructor ADD CONSTRAINT course_lab_instructor_ibfk_1 FOREIGN KEY (course_id) REFERENCES course (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        /*$this->addSql('ALTER TABLE course_lab_instructor RENAME INDEX idx_a66373f2a027defc TO lab_instructor_id');
        $this->addSql('ALTER TABLE Favorite DROP FOREIGN KEY FK_91B3EC8F21208DF3');
        $this->addSql('ALTER TABLE Favorite DROP FOREIGN KEY FK_91B3EC8FAF7ECA');
        $this->addSql('DROP INDEX IDX_91B3EC8F21208DF3 ON Favorite');
        $this->addSql('DROP INDEX IDX_91B3EC8FAF7ECA ON Favorite');*/
        $this->addSql('ALTER TABLE Favorite CHANGE StudentID StudentID INT DEFAULT NULL, CHANGE CourseID CourseID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ratingLabInstructor CHANGE lab_instructor_id lab_instructor_id INT NOT NULL, CHANGE student_id student_id INT NOT NULL');
        /*$this->addSql('ALTER TABLE ratingLabInstructor RENAME INDEX idx_6a630d36a027defc TO FK_ratingLabInstructor_labInstructor');
        $this->addSql('ALTER TABLE ratingLabInstructor RENAME INDEX idx_6a630d36cb944f1a TO FK_ratingLabInstructor_student');*/
        $this->addSql('ALTER TABLE Student CHANGE username username VARCHAR(400) DEFAULT NULL, CHANGE email email VARCHAR(1000) DEFAULT NULL, CHANGE password password VARCHAR(400) DEFAULT NULL, CHANGE phase phase INT DEFAULT NULL, CHANGE specialisation specialisation VARCHAR(400) DEFAULT NULL');
        $this->addSql('ALTER TABLE ratingProf CHANGE student_id student_id INT DEFAULT NULL, CHANGE rate_value rate_value INT DEFAULT NULL');
        /*$this->addSql('ALTER TABLE ratingProf RENAME INDEX idx_af3afb867d2d84d5 TO professor_id');
        $this->addSql('ALTER TABLE ratingProf RENAME INDEX idx_af3afb86cb944f1a TO student_id');*/
        $this->addSql('ALTER TABLE StudyMaterial CHANGE uploaded_by uploaded_by INT DEFAULT NULL, CHANGE course_id course_id INT DEFAULT NULL, CHANGE type type VARCHAR(40) DEFAULT NULL, CHANGE file_type file_type VARCHAR(50) DEFAULT NULL, CHANGE file_path file_path VARCHAR(100) DEFAULT NULL, CHANGE text text VARCHAR(2000) DEFAULT NULL');
       /* $this->addSql('ALTER TABLE StudyMaterial RENAME INDEX idx_77eb4029591cc992 TO course_id');
        $this->addSql('ALTER TABLE StudyMaterial RENAME INDEX idx_77eb4029e3e73126 TO uploaded_by');*/
        $this->addSql('ALTER TABLE Comment CHANGE type type VARCHAR(40) NOT NULL, CHANGE comment_text comment_text TEXT NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE Comment ADD CONSTRAINT Comment_ibfk_1 FOREIGN KEY (course_id) REFERENCES course (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE Comment ADD CONSTRAINT Comment_ibfk_2 FOREIGN KEY (user_id) REFERENCES Student (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX user_id ON Comment (user_id)');
        $this->addSql('CREATE INDEX course_id ON Comment (course_id)');
/*        $this->addSql('ALTER TABLE Comment RENAME INDEX idx_5bc96bf0727aca70 TO parent_id');*/
        $this->addSql('ALTER TABLE reset_password_request ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE selector selector VARCHAR(255) NOT NULL, CHANGE hashed_token hashed_token VARCHAR(255) NOT NULL, CHANGE requested_at requested_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE expires_at expires_at DATETIME NOT NULL');
/*        $this->addSql('ALTER TABLE reset_password_request RENAME INDEX idx_7ce748aa76ed395 TO user_id');*/
    }
}
