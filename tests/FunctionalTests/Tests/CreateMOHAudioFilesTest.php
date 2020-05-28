<?php
/**
 * Copyright (C) MIKO LLC - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nikolay Beketov, 5 2020
 *
 */

namespace MikoPBX\FunctionalTests\Tests;


use Facebook\WebDriver\WebDriverBy;
use MikoPBX\FunctionalTests\Lib\MikoPBXTestsBase;

class CreateMOHAudioFilesTest extends MikoPBXTestsBase
{

    /**
     * @depends      testLogin
     * @dataProvider additionProvider
     *
     * @param array $params
     *
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeoutException
     */
    public function testCreateMohFile($params):void
    {
        $this->clickSidebarMenuItemByHref('/admin-cabinet/sound-files/index/');
        $this->changeTabOnCurrentPage('moh');
        $this->clickDeleteButtonOnRowWithText('moh_'.$params['name']);

        $this->clickButtonByHref('/admin-cabinet/sound-files/modify/custom');

        $this->changeFileField('sound-file', $params['path']);


        self::$driver->wait(30, 500)->until(
            function ($driver) {
                $xpath = '//form[@id="moh-sound-files-table"]';
                $form = $driver->findElement(WebDriverBy::xpath($xpath));
                $class = $form->getAttribute('class');
                return stripos('loading', $class)!==FALSE;
            }
        );

        self::$driver->wait(30, 500)->until(
            function ($driver) {
                $xpath = '//form[@id="moh-sound-files-table"]';
                $form = $driver->findElement(WebDriverBy::xpath($xpath));
                $class = $form->getAttribute('class');
                return stripos('loading', $class)===FALSE;
            }
        );

        $this->changeInputField('name', 'moh_'.$params['name']);

        $this->submitForm('moh-sound-files-table');

        $this->clickSidebarMenuItemByHref('/admin-cabinet/sound-files/index/');
        $this->changeTabOnCurrentPage('moh');

        $this->clickModifyButtonOnRowWithText('moh_'.$params['name']);
        $this->assertInputFieldValueEqual('name', 'moh_'.$params['name']);
    }


    /**
     * Dataset provider
     * @return array
     */
    public function additionProvider(): array
    {
        $params = [];
        $params[] = [[
            'name' => 'The first audio record',
            'path'    => 'C:\Users\hello\Documents\audio\250Hz_44100Hz_16bit_05sec.wav',
        ]];
        $params[] = [[
            'name' => 'The second audio record',
            'path'    => 'C:\Users\hello\Documents\audio\blind_willie.mp3',
        ]];
        $params[] = [[
            'name' => 'The third audio record',
            'path'    => 'C:\Users\hello\Documents\audio\first_noel.mp3',
        ]];
        return $params;
    }
}