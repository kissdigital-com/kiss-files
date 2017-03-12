<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Services\ChunkyUploader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChunkyUploaderTest extends TestCase
{
    const TEST_DIRECTORY = 'tmp/test';
    const TEST_FILE = 'file.txt';
    const TEST_FILES = ['file.txt.part1', 'file.txt.part2', 'file.txt.part3'];

    public function testAddFileSuffix()
    {
        $fileName = 'foo/bar/readme.txt.gz';
        $fileName2 = ChunkyUploader::addSuffixToFilename($fileName, '-2');
        $this->assertTrue($fileName2 == 'foo/bar/readme-2.txt.gz');

        $fileName = 'foo/bar/readme.txt';
        $fileName2 = ChunkyUploader::addSuffixToFilename($fileName, '-2');
        $this->assertTrue($fileName2 == 'foo/bar/readme-2.txt');

        $fileName = 'readme.txt';
        $fileName2 = ChunkyUploader::addSuffixToFilename($fileName, '.2');
        $this->assertTrue($fileName2 == 'readme.2.txt');

        $fileName = 'foo/bar/readme';
        $fileName2 = ChunkyUploader::addSuffixToFilename($fileName, '-2');
        $this->assertTrue($fileName2 == 'foo/bar/readme-2');

        $fileName = 'readme.';
        $fileName2 = ChunkyUploader::addSuffixToFilename($fileName, '2');
        $this->assertTrue($fileName2 == 'readme.2');
    }

    public function testMergingFile()
    {
        $this->prepareTestDir();

        $parameters = ['resumableTotalChunks' => '3', 'resumableFilename' => self::TEST_FILE, 'resumableIdentifier' => 'test'];

        $request = new Request($parameters, $parameters);
        ChunkyUploader::mergeUploadedFile($request);

        $this->cleanTestDir();

        $this->assertTrue(Storage::has('uploads/'.self::TEST_FILE));
    }

    public function testCountDirSize()
    {
        $this->prepareTestDir();

        $size = ChunkyUploader::countDirectorySize(self::TEST_DIRECTORY);

        $this->cleanTestDir();

        $this->assertTrue($size == 30);
    }

    private function prepareTestDir()
    {
        $data = '0123456789';
        Storage::deleteDirectory(self::TEST_DIRECTORY);
        Storage::makeDirectory(self::TEST_DIRECTORY);

        foreach(self::TEST_FILES as $file)
        {
            file_put_contents(storage_path('app/'.self::TEST_DIRECTORY.'/'.$file), $data);
        }
    }

    private function cleanTestDir()
    {
        Storage::deleteDirectory(self::TEST_DIRECTORY);
    }
}
