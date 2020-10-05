<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\Attachment\Audio;
use Kerox\Messenger\Model\Message\Attachment\File;
use Kerox\Messenger\Model\Message\Attachment\Image;
use Kerox\Messenger\Model\Message\Attachment\Video;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testFile(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/file.json');
        $file = File::create('https://petersapparel.com/bin/receipt.pdf', true);

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($file));
    }

    public function testAudio(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/audio.json');
        $audio = Audio::create('https://petersapparel.com/bin/clip.mp3');

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($audio));
    }

    public function testVideo(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/video.json');
        $video = Video::create('https://petersapparel.com/bin/clip.mp4');

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($video));
    }

    public function testImage(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/image.json');
        $video = Image::create('https://petersapparel.com/img/shirt.png');

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($video));
    }

    public function testFileWithAttachmentId(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/file_attachment.json');
        $file = File::create('1745504518999123');

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($file));
    }
}
