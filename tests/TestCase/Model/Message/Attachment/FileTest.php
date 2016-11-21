<?php
namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\Attachment\Audio;
use Kerox\Messenger\Model\Message\Attachment\File;
use Kerox\Messenger\Model\Message\Attachment\Image;
use Kerox\Messenger\Model\Message\Attachment\Video;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class FileTest extends AbstractTestCase
{

    public function testFile()
    {
        $file = new File('https://petersapparel.com/bin/receipt.pdf', true);

        $this->assertJsonStringEqualsJsonString('{"type":"file","payload":{"url":"https://petersapparel.com/bin/receipt.pdf","is_reusable":true}}', json_encode($file));
    }

    public function testAudio()
    {
        $audio = new Audio('https://petersapparel.com/bin/clip.mp3');

        $this->assertJsonStringEqualsJsonString('{"type":"audio","payload":{"url":"https://petersapparel.com/bin/clip.mp3"}}', json_encode($audio));
    }

    public function testVideo()
    {
        $video = new Video('https://petersapparel.com/bin/clip.mp4');

        $this->assertJsonStringEqualsJsonString('{"type":"video","payload":{"url":"https://petersapparel.com/bin/clip.mp4"}}', json_encode($video));
    }

    public function testImage()
    {
        $video = new Image('https://petersapparel.com/img/shirt.png');

        $this->assertJsonStringEqualsJsonString('{"type":"image","payload":{"url":"https://petersapparel.com/img/shirt.png"}}', json_encode($video));
    }

    public function testFileWithAttachmentId()
    {
        $file = new File('1745504518999123');

        $this->assertJsonStringEqualsJsonString('{"type":"file","payload":{"attachment_id":"1745504518999123"}}', json_encode($file));
    }
}