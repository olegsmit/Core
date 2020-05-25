<?php
/**
 * Copyright (C) MIKO LLC - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nikolay Beketov, 5 2020
 *
 */

namespace MikoPBX\FunctionalTests\Lib;

use Facebook\WebDriver\WebDriverBy;
use MikoPBX\FunctionalTests\Tests\LoginTrait;


class MikoPBXTestsBase extends BrowserStackTest
{
    use  LoginTrait;

    /**
     * Assert that menu item not found on the page
     *
     * @param $by
     */
    protected function assertElementNotFound($by): void
    {
        $els = self::$driver->findElements($by);
        if (count($els)) {
            $this->fail("Unexpectedly element was found");
        }
        // increment assertion counter
        $this->assertTrue(true);
    }

    /**
     * Select dropdown menu item
     *
     * @param $name  string menu name identifier
     * @param $value string menu value for select
     *
     */
    protected function selectDropdownItem(string $name, string $value): void
    {
        $xpath = '//select[@name="' . $name . '"]/ancestor::div[contains(@class, "ui") and contains(@class ,"dropdown")]';
        try {
            $selectItem = self::$driver->findElement(WebDriverBy::xpath($xpath));
            $selectItem->click();
            // Находим строчку с нужной опцией по значению
            $xpath    = '//div[contains(@class, "menu") and contains(@class ,"visible")]/div[@data-value="' . $value . '"]';
            $menuItem = self::$driver->wait()->until(
                \Facebook\WebDriver\WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath($xpath))
            );
            $menuItem->click();
        } catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
            echo('Not found submit button on this page');
        } catch (\Facebook\WebDriver\Exception\TimeoutException $e) {
            echo('Form doesn\'t send after 10 seconds timeout');
        } catch (\Exception $e) {
            echo('Unknown error');
        }
    }

    /**
     * Assert that menu item selected
     *
     * @param $name  string menu name
     * @param $value string checked value
     */
    protected function assertMenuItemSelected(string $name, string $value): void
    {
        $xpath             = '//select[@name="' . $name . '"]/option[@selected="selected"]';
        $selectedExtension = self::$driver->findElements(WebDriverBy::xpath($xpath));
        foreach ($selectedExtension as $element) {
            $this->assertEquals($value, $element->getAttribute('value'));
        }
    }

    /**
     * Change textarea with name $name value to $value
     *
     * @param string $name
     * @param string $value
     */
    protected function changeTextAreaValue(string $name, string $value): void
    {
        $xpath         = ('//textarea[@name="' . $name . '"]');
        $textAreaItems = self::$driver->findElements(WebDriverBy::xpath($xpath));
        foreach ($textAreaItems as $textAreaItem) {
            $textAreaItem->click();
            $textAreaItem->clear();
            $textAreaItem->sendKeys($value);
        }
    }

    /**
     * Assert that textArea value is equal
     *
     * @param string $name  textArea name
     * @param string $value checked value
     */
    protected function assertTextAreaValueIsEqual(string $name, string $value): void
    {
        $xpath        = '//textarea[@name="' . $name . '"]';
        $textAreaItem = self::$driver->findElement(WebDriverBy::xpath($xpath));
        if ($textAreaItem) {
            $this->assertEquals($value, $textAreaItem->getAttribute('value'));
        }
    }


    /**
     * If file filed with $name exists on the page, it value will be changed on $value
     *
     * @param string $name
     * @param string $value
     */
    protected function changeFileField(string $name, string $value): void
    {
        $xpath      = '//input[@name="' . $name . '" and (@type = "file")]';
        $inputItems = self::$driver->findElements(WebDriverBy::xpath($xpath));
        foreach ($inputItems as $inputItem) {
            $inputItem->sendKeys($value);
        }
    }

    /**
     * If input filed with $name exists on the page, it value will be changed on $value
     *
     * @param string $name
     * @param string $value
     */
    protected function changeInputField(string $name, string $value): void
    {
        $xpath      = '//input[@name="' . $name . '" and (@type="text" or @type="password" or @type="hidden")]';
        $inputItems = self::$driver->findElements(WebDriverBy::xpath($xpath));
        foreach ($inputItems as $inputItem) {
            $inputItem->click();
            $inputItem->clear();
            $inputItem->sendKeys($value);
        }
    }

    /**
     * Assert that input field with name $name value is equal to $value
     * @param string $name
     * @param string $value
     */
    protected function assertInputFieldValueEqual(string $name, string $value):void{
        $xpath      = '//input[@name="' . $name . '" and (@type="text" or @type="password" or @type="hidden")]';
        $inputItems = self::$driver->findElements(WebDriverBy::xpath($xpath));
        foreach ($inputItems as $inputItem) {
            $this->assertEquals($value, $inputItem->getAttribute('value'));
        }
    }

    /**
     * Change checkbox state according the $enabled value if checkbox with the $name exist on the page
     *
     * @param string $name
     * @param bool   $enabled
     */
    protected function changeCheckBoxState(string $name, bool $enabled): void
    {
        $xpath         = '//input[@name="' . $name . '" and @type="checkbox"]';
        $checkBoxItems = self::$driver->findElements(WebDriverBy::xpath($xpath));
        foreach ($checkBoxItems as $checkBoxItem) {
            if (
                ($enabled && ! $checkBoxItem->isSelected())
                ||
                ( ! $enabled && $checkBoxItem->isSelected())
            ) {
                $xpath        = '//input[@name="' . $name . '" and @type="checkbox"]/parent::div';
                $checkBoxItem = self::$driver->findElement(WebDriverBy::xpath($xpath));
                $checkBoxItem->click();
            }
        }
    }
    /**
     * Assert that checkBox state is equal to the $enabled if checkbox with the $name exist on the page
     *
     * @param string $name    checkBox name
     * @param bool   $enabled checked state
     */
    protected function assertCheckBoxStageIsEqual(string $name, bool $enabled): void
    {
        $xpath         = '//input[@name="' . $name . '" and @type="checkbox"]';
        $checkBoxItems = self::$driver->findElements(WebDriverBy::xpath($xpath));
        foreach ($checkBoxItems as $checkBoxItem) {
            if ($enabled) {
                $this->assertTrue($checkBoxItem->isSelected(), "{$name} Must be checked");
            } else {
                $this->assertFalse($checkBoxItem->isSelected(), "{$name} Must be unchecked");
            }
        }
    }

    /**
     * Submit form with id - $formId and wait until form send
     *
     * @param string $formId
     *
     */
    protected function submitForm(string $formId): void
    {
        $xpath = '//form[@id="' . $formId . '"]//ancestor::div[@id="submitbutton"]';
        try {
            $button_Submit = self::$driver->findElement(WebDriverBy::xpath($xpath));
            if ($button_Submit) {
                $button_Submit->click();
                self::$driver->wait(10, 500)->until(
                    function ($driver) use ($xpath) {
                        $button_Submit = $driver->findElement(WebDriverBy::xpath($xpath));

                        return $button_Submit->isEnabled();
                    }
                );
            }
        } catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
            echo('Not found submit button on this page');
        } catch (\Facebook\WebDriver\Exception\TimeoutException $e) {
            echo('Form doesn\'t send after 10 seconds timeout');
        } catch (\Exception $e) {
            echo('Unknown error');
        }
    }

    /**
     * Click on the left sidebar menu item
     * @param string $href
     */
    protected function clickSidebarMenuItemByHref(string $href):void
    {
        try {
            $xpath                  = '//div[@id="sidebar-menu"]//ancestor::a[contains(@class, "item") and contains(@href ,"'.$href.'")]';
            $sidebarItem = self::$driver->findElement(WebDriverBy::xpath($xpath));
            $sidebarItem->click();
        } catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
            echo('Not found sidebar item with href='.$href.' on this page');
        } catch (\Exception $e) {
            echo('Unknown error');
        }
    }

    /**
     * Find modify button on row with text $text and click it
     * @param string $text
     */
    protected function clickModifyButtonOnRowWithText(string $text):void
    {
        $xpath = ('//td[contains(text(),"'.$text.'")]/ancestor::tr[contains(@class, "row")]//a[contains(@href,"modify")]');
        try {
            $tableButtonModify = self::$driver->findElement(WebDriverBy::xpath($xpath));
            $tableButtonModify->click();
        } catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
            echo('Not found row with text='.$text.' on this page');
        } catch (\Exception $e) {
            echo('Unknown error');
        }
    }

    /**
     * Click on add new button by href
     * @param string $href
     */
    protected function clickAddNewButtonByHref(string $href):void {
        try {
            $xpath             = "//a[@href = '{$href}' and @id = 'add-new-button']";
            $button_AddNew = self::$driver->findElement(WebDriverBy::xpath($xpath));
            $button_AddNew ->click();
        } catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
            echo('Not found button with href='.$href.' on this page');
        } catch (\Exception $e) {
            echo('Unknown error');
        }
    }
}