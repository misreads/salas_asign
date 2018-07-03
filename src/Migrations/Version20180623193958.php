<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180623193958 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE faculty_department ADD faculty_id INT NOT NULL, ADD department_id INT NOT NULL');
        $this->addSql('ALTER TABLE faculty_department ADD CONSTRAINT FK_FFEA69EA680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id)');
        $this->addSql('ALTER TABLE faculty_department ADD CONSTRAINT FK_FFEA69EAAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('CREATE INDEX IDX_FFEA69EA680CAB68 ON faculty_department (faculty_id)');
        $this->addSql('CREATE INDEX IDX_FFEA69EAAE80F5DF ON faculty_department (department_id)');
        $this->addSql('ALTER TABLE section ADD subject_id INT NOT NULL, ADD schedule_id INT NOT NULL, ADD professor_id INT NOT NULL');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEFA40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF7D2D84D5 FOREIGN KEY (professor_id) REFERENCES professor (id)');
        $this->addSql('CREATE INDEX IDX_2D737AEF23EDC87 ON section (subject_id)');
        $this->addSql('CREATE INDEX IDX_2D737AEFA40BC2D5 ON section (schedule_id)');
        $this->addSql('CREATE INDEX IDX_2D737AEF7D2D84D5 ON section (professor_id)');
        $this->addSql('ALTER TABLE career ADD faculty_department_id INT NOT NULL');
        $this->addSql('ALTER TABLE career ADD CONSTRAINT FK_B25B6C8436D44B31 FOREIGN KEY (faculty_department_id) REFERENCES faculty_department (id)');
        $this->addSql('CREATE INDEX IDX_B25B6C8436D44B31 ON career (faculty_department_id)');
        $this->addSql('ALTER TABLE subject ADD career_id INT NOT NULL');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7AB58CDA09 FOREIGN KEY (career_id) REFERENCES career (id)');
        $this->addSql('CREATE INDEX IDX_FBCE3E7AB58CDA09 ON subject (career_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE career DROP FOREIGN KEY FK_B25B6C8436D44B31');
        $this->addSql('DROP INDEX IDX_B25B6C8436D44B31 ON career');
        $this->addSql('ALTER TABLE career DROP faculty_department_id');
        $this->addSql('ALTER TABLE faculty_department DROP FOREIGN KEY FK_FFEA69EA680CAB68');
        $this->addSql('ALTER TABLE faculty_department DROP FOREIGN KEY FK_FFEA69EAAE80F5DF');
        $this->addSql('DROP INDEX IDX_FFEA69EA680CAB68 ON faculty_department');
        $this->addSql('DROP INDEX IDX_FFEA69EAAE80F5DF ON faculty_department');
        $this->addSql('ALTER TABLE faculty_department DROP faculty_id, DROP department_id');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF23EDC87');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEFA40BC2D5');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF7D2D84D5');
        $this->addSql('DROP INDEX IDX_2D737AEF23EDC87 ON section');
        $this->addSql('DROP INDEX IDX_2D737AEFA40BC2D5 ON section');
        $this->addSql('DROP INDEX IDX_2D737AEF7D2D84D5 ON section');
        $this->addSql('ALTER TABLE section DROP subject_id, DROP schedule_id, DROP professor_id');
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7AB58CDA09');
        $this->addSql('DROP INDEX IDX_FBCE3E7AB58CDA09 ON subject');
        $this->addSql('ALTER TABLE subject DROP career_id');
    }
}
