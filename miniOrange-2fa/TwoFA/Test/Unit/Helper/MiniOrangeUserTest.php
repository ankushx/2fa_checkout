<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper;

use MiniOrange\TwoFA\Helper\MiniOrangeUser;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
class MiniOrangeUserTest extends TestCase
{
    private $user;
    private $TwoFAUtility;
    protected function setUp() : void
    {
        $this->user = new MiniOrangeUser();
        $this->TwoFAUtility = $this->getMockBuilder(\stdClass::class)->addMethods(["\154\157\x67\137\144\145\142\x75\147", "\x67\145\164\101\154\x6c\115\157\x54\146\141\x55\x73\145\x72\x44\145\x74\x61\x69\154\163", "\x67\145\x74\103\x75\x73\x74\157\155\x65\x72\113\145\171\163", "\x67\x65\x74\123\145\163\163\151\157\x6e\x56\141\x6c\165\x65", "\147\145\164\124\162\141\x6e\163\x61\143\164\151\157\x6e\x4e\x61\x6d\x65", "\x67\145\x74\101\160\x69\125\162\154\163"])->getMock();
        $this->patchCurlStatic();
    }
    public function testSetUserInfoData()
    {
        if (method_exists($this->user, "\x73\x65\164\125\x73\145\162\111\x6e\146\x6f\104\x61\164\x61")) {
            goto vZsYH;
        }
        $this->markTestSkipped("\x73\145\x74\x55\x73\145\x72\x49\156\x66\x6f\x44\141\x74\141\40\x64\157\x65\x73\x20\x6e\x6f\164\x20\x65\170\151\x73\164\40\157\x72\x20\x69\163\x20\156\157\164\x20\160\x75\142\154\151\x63\56");
        vZsYH:
        $f9yh7 = ["\x75\163\145\162\156\141\x6d\x65" => "\x75\x73\x65\x72", "\x70\x68\157\156\x65" => "\x31\62\x33", "\x65\x6d\x61\x69\x6c" => "\x61\x40\142\56\x63\157\155", "\143\x6f\165\x6e\x74\162\x79\x63\x6f\x64\x65" => "\x39\x31"];
        $g92Ig = $this->user->setUserInfoData($f9yh7);
        $this->assertSame($this->user, $g92Ig);
    }
    public function testChallenge_PositiveFlow()
    {
        $this->mockTwoFAUtilityForChallenge("\x4f\117\x53");
        $g92Ig = $this->user->challenge("\165\163\x65\162\x40\145\x78\x61\155\160\x6c\x65\x2e\143\x6f\x6d", $this->TwoFAUtility, "\117\x4f\x53", false, 1);
        $this->assertEquals("\x7b\42\163\164\x61\x74\165\163\x22\x3a\42\123\125\x43\x43\105\123\123\42\x2c\42\x6d\x65\x73\163\x61\147\145\42\72\x22\157\153\42\x2c\42\x74\x78\x49\x64\42\x3a\x22\x31\42\175", $g92Ig);
    }
    public function testChallenge_MissingRowData()
    {
        $this->mockTwoFAUtilityForChallenge("\x4f\x4f\123", []);
        $g92Ig = $this->user->challenge("\165\x73\145\x72\100\x65\x78\141\155\160\x6c\145\56\x63\x6f\x6d", $this->TwoFAUtility, "\117\x4f\x53", false, 1);
        $this->assertEquals("\x7b\42\x73\x74\141\x74\x75\163\42\x3a\42\x53\125\103\x43\x45\123\x53\x22\54\x22\155\145\x73\x73\141\147\x65\42\x3a\42\x6f\x6b\42\x2c\42\x74\170\x49\144\42\x3a\42\x31\42\x7d", $g92Ig);
    }
    public function testChallenge_WithUserInfoData()
    {
        $this->user->setUserInfoData(["\165\163\145\162\156\x61\155\145" => "\x75\163\x65\x72", "\x70\150\x6f\x6e\145" => "\61\x32\x33", "\x65\x6d\141\x69\154" => "\x61\x40\142\56\143\x6f\x6d", "\143\157\165\156\x74\x72\x79\143\x6f\144\145" => "\x39\x31"]);
        $this->mockTwoFAUtilityForChallenge("\117\x4f\x53");
        $g92Ig = $this->user->challenge("\x75\163\x65\x72\100\145\x78\141\155\160\154\x65\x2e\x63\157\x6d", $this->TwoFAUtility, "\x4f\117\123", false, 1);
        $this->assertEquals("\173\42\163\x74\141\x74\165\163\42\x3a\x22\x53\x55\x43\103\x45\123\123\x22\x2c\x22\x6d\145\163\163\x61\x67\145\x22\x3a\42\x6f\153\42\54\42\x74\170\x49\x64\x22\72\x22\x31\42\x7d", $g92Ig);
    }
    public function testChallenge_ConfigureTrue()
    {
        $this->mockTwoFAUtilityForChallenge("\x4f\117\105");
        $g92Ig = $this->user->challenge("\165\163\145\162\100\x65\170\141\155\160\154\145\56\x63\157\x6d", $this->TwoFAUtility, "\117\x4f\x45", true, 1);
        $this->assertEquals("\x7b\x22\x73\x74\141\164\165\x73\42\x3a\x22\x53\x55\x43\103\x45\123\123\x22\54\42\x6d\145\163\x73\141\147\x65\42\x3a\x22\157\153\x22\x2c\x22\164\170\111\144\x22\x3a\x22\61\42\175", $g92Ig);
    }
    public function testChallenge_UnknownAuthType()
    {
        $this->mockTwoFAUtilityForChallenge("\x55\116\113\116\x4f\127\x4e");
        $g92Ig = $this->user->challenge("\x75\163\145\x72\100\x65\x78\141\x6d\x70\x6c\x65\56\143\157\x6d", $this->TwoFAUtility, "\125\116\113\116\117\x57\116", false, 1);
        $this->assertEquals("\173\x22\163\164\x61\164\x75\x73\x22\x3a\42\123\125\x43\x43\105\123\x53\x22\x2c\42\155\145\x73\163\141\147\x65\x22\x3a\x22\x6f\x6b\42\x2c\x22\x74\x78\x49\x64\42\72\x22\61\42\175", $g92Ig);
    }
    public function testMo2fUpdateUserinfo_PositiveFlow()
    {
        $this->mockTwoFAUtilityForUpdate();
        $g92Ig = $this->user->mo2f_update_userinfo($this->TwoFAUtility, "\165\x73\x65\x72\100\x65\x78\141\155\160\x6c\145\x2e\143\x6f\x6d", "\117\x4f\x53", "\61\x32\x33");
        $this->assertEquals("\165\160\x64\141\x74\145\x2d\x72\145\x73\x75\154\x74", $g92Ig);
    }
    public function testMo2fUpdateUserinfo_EmptyAuthType()
    {
        $this->mockTwoFAUtilityForUpdate();
        $g92Ig = $this->user->mo2f_update_userinfo($this->TwoFAUtility, "\x75\163\145\x72\x40\x65\x78\141\155\160\x6c\145\56\143\157\155", '', '');
        $this->assertEquals("\165\x70\144\141\x74\x65\55\x72\145\x73\165\x6c\x74", $g92Ig);
    }
    public function testMo2fUpdateUserinfo_GoogleAuthenticator()
    {
        $this->mockTwoFAUtilityForUpdate();
        $g92Ig = $this->user->mo2f_update_userinfo($this->TwoFAUtility, "\165\x73\145\x72\x40\x65\170\x61\x6d\160\x6c\x65\x2e\143\x6f\155", "\107\157\x6f\x67\x6c\145\x41\x75\164\150\145\156\164\x69\x63\x61\164\157\162", '');
        $this->assertEquals("\165\160\144\x61\164\x65\x2d\162\x65\163\x75\154\x74", $g92Ig);
    }
    public function testMoCreateUser_PositiveFlow()
    {
        $this->mockTwoFAUtilityForUpdate();
        $g92Ig = $this->user->mo_create_user($this->TwoFAUtility, "\165\163\x65\162\100\145\170\141\155\x70\x6c\x65\56\143\x6f\155", "\117\x4f\x53", "\x31\62\63");
        $this->assertEquals("\x75\160\144\141\x74\145\x2d\x72\x65\163\165\154\164", $g92Ig);
    }
    public function testMoCreateUser_EmptyAuthType()
    {
        $this->mockTwoFAUtilityForUpdate();
        $g92Ig = $this->user->mo_create_user($this->TwoFAUtility, "\165\163\145\162\x40\x65\170\x61\x6d\x70\154\145\56\x63\x6f\x6d", '', '');
        $this->assertEquals("\x75\x70\x64\141\x74\x65\x2d\x72\145\x73\165\x6c\x74", $g92Ig);
    }
    public function testMoCreateUser_GoogleAuthenticator()
    {
        $this->mockTwoFAUtilityForUpdate();
        $g92Ig = $this->user->mo_create_user($this->TwoFAUtility, "\165\x73\145\x72\x40\145\170\141\155\x70\154\x65\56\x63\157\x6d", "\107\x6f\x6f\x67\154\145\x41\x75\164\150\145\x6e\164\x69\x63\x61\164\157\x72", '');
        $this->assertEquals("\165\x70\144\x61\164\x65\x2d\162\145\163\x75\x6c\164", $g92Ig);
    }
    public function testValidate_PositiveFlow()
    {
        $this->mockTwoFAUtilityForValidate();
        $g92Ig = $this->user->validate("\x75\x73\x65\162\100\x65\x78\x61\x6d\160\x6c\x65\x2e\143\x6f\155", "\x74\x6f\153\x65\156", "\x4f\117\123", $this->TwoFAUtility, null, false, 1);
        $this->assertEquals("\173\x22\x73\x74\x61\x74\165\163\42\x3a\42\123\125\x43\x43\x45\x53\123\42\175", $g92Ig);
    }
    public function testValidate_WithUserInfoData()
    {
        $this->user->setUserInfoData(["\165\163\145\x72\156\141\x6d\145" => "\165\x73\145\162", "\164\162\x61\156\x73\141\x63\x74\x69\157\x6e\111\144" => "\x74\170\151\144"]);
        $this->mockTwoFAUtilityForValidate();
        $g92Ig = $this->user->validate("\x75\x73\x65\x72\x40\145\170\x61\155\x70\x6c\145\56\x63\x6f\155", "\164\157\153\145\x6e", "\x4f\x4f\x53", $this->TwoFAUtility, null, false, 1);
        $this->assertEquals("\x7b\42\163\164\141\164\165\163\42\x3a\x22\123\125\x43\103\x45\123\123\42\x7d", $g92Ig);
    }
    public function testValidate_MissingRowData()
    {
        $this->mockTwoFAUtilityForValidate([]);
        $g92Ig = $this->user->validate("\165\163\145\162\100\x65\x78\x61\x6d\x70\x6c\x65\x2e\143\x6f\155", "\164\x6f\153\x65\156", "\117\117\123", $this->TwoFAUtility, null, false, 1);
        $this->assertEquals("\x7b\x22\x73\x74\x61\x74\165\x73\x22\72\x22\x53\125\x43\103\x45\123\x53\x22\175", $g92Ig);
    }
    public function testValidate_ConfiguringTrue()
    {
        $this->mockTwoFAUtilityForValidate();
        $g92Ig = $this->user->validate("\x75\x73\x65\x72\100\x65\170\x61\155\160\154\x65\56\x63\157\x6d", "\x74\x6f\x6b\x65\156", "\x4f\117\x53", $this->TwoFAUtility, null, true, 1);
        $this->assertEquals("\173\42\x73\x74\141\x74\x75\x73\x22\x3a\42\123\x55\103\x43\x45\x53\123\x22\x7d", $g92Ig);
    }
    private function mockTwoFAUtilityForChallenge($ScdjK, $nK1pf = array(array("\160\150\x6f\156\145" => "\61\x32\63", "\145\155\x61\x69\x6c" => "\141\x40\x62\56\x63\x6f\155", "\x63\157\165\156\164\162\x79\x63\157\x64\x65" => "\x39\x31")))
    {
        $this->TwoFAUtility->method("\x6c\157\147\x5f\144\145\142\165\147");
        $this->TwoFAUtility->method("\147\145\x74\101\154\x6c\x4d\157\x54\x66\141\125\163\x65\162\x44\145\164\x61\x69\154\x73")->willReturn($nK1pf);
        $this->TwoFAUtility->method("\x67\145\164\103\165\x73\164\157\155\145\162\113\x65\171\x73")->willReturn(["\x63\165\163\x74\157\155\x65\162\137\153\x65\171" => "\x6b\x65\171", "\141\x70\x69\113\145\x79" => "\x61\160\x69"]);
        $this->TwoFAUtility->method("\147\x65\164\x53\x65\163\163\151\x6f\156\x56\141\154\165\x65")->willReturn(null);
        $this->TwoFAUtility->method("\147\145\164\x54\x72\141\x6e\x73\x61\143\x74\151\157\x6e\116\x61\155\x65")->willReturn("\164\x78\156");
        $this->TwoFAUtility->method("\147\145\164\101\160\x69\x55\x72\x6c\x73")->willReturn(["\143\x68\141\154\154\141\x6e\147\x65" => "\165\162\x6c"]);
    }
    private function mockTwoFAUtilityForUpdate()
    {
        $this->TwoFAUtility->method("\154\x6f\x67\137\x64\145\x62\165\x67");
        $this->TwoFAUtility->method("\147\145\x74\103\x75\163\x74\157\x6d\145\162\113\145\x79\163")->willReturn(["\143\165\163\164\157\155\145\x72\x5f\x6b\145\171" => "\153\145\x79", "\141\160\151\x4b\x65\171" => "\141\x70\x69"]);
        $this->TwoFAUtility->method("\147\x65\164\124\162\141\x6e\163\x61\143\164\x69\157\156\116\x61\x6d\x65")->willReturn("\x74\x78\x6e");
        $this->TwoFAUtility->method("\x67\x65\164\101\160\151\x55\x72\x6c\163")->willReturn(["\165\x70\144\x61\164\145" => "\x75\x72\x6c", "\143\x72\145\141\164\145\125\163\x65\162" => "\x75\162\154"]);
    }
    private function mockTwoFAUtilityForValidate($nK1pf = array(array("\164\162\141\156\x73\x61\143\x74\151\x6f\156\x49\144" => "\x74\170\x69\144")))
    {
        $this->TwoFAUtility->method("\154\x6f\x67\137\144\x65\x62\x75\x67");
        $this->TwoFAUtility->method("\x67\145\164\x43\x75\x73\x74\157\155\x65\x72\113\x65\x79\x73")->willReturn(["\143\165\x73\x74\157\x6d\x65\162\137\x6b\x65\171" => "\x6b\x65\171", "\141\160\x69\x4b\145\171" => "\141\x70\151"]);
        $this->TwoFAUtility->method("\x67\145\x74\101\x6c\x6c\x4d\x6f\124\146\x61\125\163\145\162\104\145\164\x61\151\x6c\163")->willReturn($nK1pf);
        $this->TwoFAUtility->method("\147\145\164\x53\145\163\x73\151\x6f\156\x56\x61\154\x75\x65")->willReturn(null);
        $this->TwoFAUtility->method("\147\145\164\101\x70\x69\125\162\154\x73")->willReturn(["\166\141\154\x69\x64\x61\x74\145" => "\x75\x72\154"]);
    }
    private function patchCurlStatic()
    {
        if (class_exists("\115\x69\x6e\151\x4f\x72\141\x6e\147\x65\x5c\x54\x77\x6f\106\101\134\x48\145\x6c\x70\x65\162\134\103\165\162\154")) {
            goto the0p;
        }
        eval("\15\12\40\40\x20\x20\x20\x20\x20\x20\x20\40\x20\40\40\x20\40\40\156\x61\x6d\x65\x73\160\141\143\145\40\x4d\x69\156\151\117\162\x61\x6e\x67\145\134\x54\167\x6f\x46\101\x5c\110\x65\x6c\160\x65\162\73\15\12\x20\40\x20\x20\40\x20\x20\40\x20\x20\x20\40\40\x20\x20\x20\143\x6c\141\x73\x73\x20\103\x75\162\x6c\x20\173\15\12\x20\x20\40\x20\40\x20\40\x20\40\40\x20\x20\40\x20\40\x20\x20\40\40\40\160\x75\x62\x6c\151\x63\x20\x73\164\x61\164\x69\x63\40\146\165\156\x63\164\151\x6f\x6e\40\x63\150\x61\154\154\x65\156\147\x65\50\x29\x20\173\x20\162\x65\164\x75\x72\156\40\42\143\150\141\154\154\145\156\x67\145\55\x72\145\163\165\154\x74\42\73\x20\x7d\15\xa\x20\40\x20\x20\x20\x20\x20\40\40\40\x20\40\40\40\x20\x20\40\x20\x20\x20\x70\165\x62\154\x69\x63\x20\x73\164\x61\x74\151\143\40\x66\x75\156\143\x74\151\157\156\40\x75\160\x64\141\164\145\x28\x29\40\x7b\x20\162\x65\164\x75\x72\156\x20\42\165\160\144\x61\164\145\55\x72\x65\163\165\x6c\x74\x22\x3b\40\175\15\xa\x20\x20\x20\x20\x20\40\x20\x20\40\x20\x20\x20\40\40\40\40\x20\40\40\40\x70\165\x62\154\151\x63\x20\163\164\x61\164\x69\143\x20\x66\165\x6e\143\164\151\157\x6e\40\x76\x61\x6c\151\144\141\164\x65\50\x29\40\173\40\x72\x65\x74\165\162\x6e\x20\42\x76\141\154\x69\144\141\164\x65\x2d\x72\x65\163\x75\154\x74\42\73\x20\x7d\xd\12\40\x20\40\40\x20\40\40\x20\40\x20\40\40\x20\x20\40\x20\175\xd\12\x20\40\x20\40\x20\40\x20\40\x20\40\x20\40");
        the0p:
    }
}