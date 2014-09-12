<?php
class Interactions extends PHPUnit_Extensions_SeleniumTestCase
{
  protected function setUp()
  {
    $this->setBrowser("*firefox");
    $this->setBrowserUrl("http://ding2tal.easyting.dk/");
  }

  public function testYearbookReservation()
  {
    $this->open("/en");
    // Reset mock object.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://alma.am.ci.inlead.dk/web/reset.php");
    curl_exec($ch);
    curl_close($ch);
    $this->click("link=Login");
    $this->type("id=edit-name", "1111110022");
    $this->type("id=edit-pass", "5555");
    $this->click("id=edit-submit--2");
    $this->waitForPageToLoad("30000");
    $this->type("id=edit-search-block-form--2", "Folkepension og delpension");
    $this->click("id=edit-submit");
    $this->waitForPageToLoad("30000");
    $this->assertContains('Folkepension og delpension', $this->getText("css=li.list-item.search-result"), '', true);
    $this->click("id=availability-870970-basis10122945-periodikum");
    $this->waitForPageToLoad("30000");
    $this->assertEquals("Folkepension og delpension", $this->getText("link=Folkepension og delpension"));
    $this->click("link=Issues");
    $this->assertEquals("2014", $this->getText("//div[@id='page']/div/div/div/div/div/div/div/div/div/div/div[4]/div/div/div/div/div/div/ul/li/div"));
    $this->click("//div[@id='page']/div/div/div/div/div/div/div/div/div/div/div[4]/div/div/div/div/div/div/ul/li/div");
    $this->assertEquals("130. udgave", $this->getText("id=periodical-id-42e4185dc40a193d98a9729716439873"));
    $this->click("id=periodical-id-42e4185dc40a193d98a9729716439873");
    $this->assertTrue($this->isElementPresent("id=reservation-10122945ZXZX130. udgaveZX2014ZXZX"));
    $this->assertTrue($this->isElementPresent("css=div.periodical-holdings > table > tbody > tr.odd > td"));
    $this->click("id=reservation-10122945ZXZX130. udgaveZX2014ZXZX");
    sleep(4);
    $this->assertEquals('Status message "Folkepension og delpension, vol 2014, issue 130. udgave" reserved and will be available for pickup at Sindal. You are number 1 in queue.', $this->getText("css=div.messages"));
    $this->click("//div[4]/div/button");
  }
}