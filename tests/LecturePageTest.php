<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class LecturePageTest extends PantherTestCase
{

    public function testLecturePageLoads()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/lecture/117/Lecture'); // Update with actual URL

        // Debugging: Print the HTML content for the page to a file
        file_put_contents('page_content.html', $crawler->html());

        // Check that the response is successful
        $this->assertGreaterThan(
            0,
            $crawler->filterXPath('//h1[contains(text(), "Lecture")]')->count(),
            'The lecture page should contain an H1 with "Lecture"'
        );

        // Check for average course rating or "No ratings available" message
        $this->assertGreaterThanOrEqual(
            1,
            $crawler->filterXPath('//div[contains(@class, "ratings-section")]//p[contains(text(), "Exam Difficulty:") or contains(text(), "No ratings available")]')->count(),
            'There should be either an average course rating or a "No ratings available" message'
        );
    }



    public function testLectureDifficultyRating()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/lecture/117/Lecture'); // Replace with actual ID and type

        // Check for average course rating or "No ratings available" message
        $this->assertGreaterThanOrEqual(
            1,
            $crawler->filter('.ratings-section .card-text:contains("Exam Difficulty:")')->count() +
            $crawler->filter('.ratings-section .card-text:contains("No ratings available.")')->count()
        );

        // Check for rate exam button
        $this->assertCount(1, $crawler->filter('.ratings-section a[href*="rate_this_exam"]'));
    }

    public function testLectureProfessorRating()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/lecture/117/Lecture');

        // Check for average professor rating or "No ratings available" message
        $this->assertGreaterThanOrEqual(
            1,
            $crawler->filter('.ratings-section .card-title:contains("Professor Name:")')->count() +
            $crawler->filter('.ratings-section .card-text:contains("No ratings available.")')->count()
        );

        // Check for rate professor button
        $this->assertCount(1, $crawler->filter('.ratings-section a[href*="rate_professor"]'));
    }


    public function testMaterialsSection()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/lecture/117/Lecture'); // Replace with actual ID and type

        // Check for materials section
        $this->assertCount(1, $crawler->filter('h2:contains("Materials")'));

        // Check for at least one material link
        $this->assertGreaterThan(
            0,
            $crawler->filter('.materials-section .pdf-link a')->count()
        );
    }


    public function testCommentsSection()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/lecture/117/Lecture'); // Replace with actual ID and type

        // Check for comments section
        $this->assertCount(1, $crawler->filter('h2:contains("Comments")'));

        // Check for comment form
        $this->assertCount(1, $crawler->filter('.comment-form form'));

        // Check for existing comments
        $this->assertGreaterThan(
            0,
            $crawler->filter('.comment-list .comment-wrapper')->count()
        );

        // Check for reply buttons
        $this->assertGreaterThan(
            0,
            $crawler->filter('.reply-button')->count()
        );
    }
}
