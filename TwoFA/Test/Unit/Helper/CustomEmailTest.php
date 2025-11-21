<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper;

use MiniOrange\TwoFA\Helper\CustomEmail;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Helper\Context;
use Magento\Email\Model\BackendTemplate;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Email\Model\Template\SenderResolver;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use Magento\Framework\Mail\TransportInterface;
use Magento\Store\Api\Data\StoreInterface;
class CustomEmailTest extends TestCase
{
    private $twofautility;
    private $emailTemplate;
    private $inlineTranslation;
    private $escaper;
    private $transportBuilder;
    private $senderResolver;
    private $storeManager;
    private $customerRepository;
    private $context;
    private $customEmail;
    protected function setUp() : void
    {
        $this->twofautility = $this->createMock(TwoFAUtility::class);
        $this->emailTemplate = $this->createMock(BackendTemplate::class);
        $this->inlineTranslation = $this->createMock(StateInterface::class);
        $this->escaper = $this->createMock(Escaper::class);
        $this->transportBuilder = $this->createMock(TransportBuilder::class);
        $this->senderResolver = $this->createMock(SenderResolver::class);
        $this->storeManager = $this->createMock(StoreManagerInterface::class);
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->context = $this->createMock(Context::class);
        $this->context->method("\x67\145\164\114\x6f\147\147\145\x72")->willReturn($this->createMock(\Psr\Log\LoggerInterface::class));
        $this->customEmail = new CustomEmail($this->context, $this->twofautility, $this->emailTemplate, $this->inlineTranslation, $this->escaper, $this->transportBuilder, $this->senderResolver, $this->storeManager, $this->customerRepository);
    }
    public function testSendCustomgatewayEmailPositive()
    {
        $tyorZ = "\x75\163\x65\162\x40\x65\x78\141\x6d\x70\x6c\145\x2e\x63\x6f\155";
        $A2Q8p = "\61\62\x33\64\65\66";
        $P9ID7 = $this->createMock(StoreInterface::class);
        $e8Ud6 = $this->createMock(TransportInterface::class);
        $jItv1 = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);
        $jItv1->method("\147\x65\x74\106\151\x72\x73\x74\156\141\155\145")->willReturn("\x4a\x6f\x68\x6e");
        $jItv1->method("\147\145\164\x4c\x61\x73\x74\156\141\x6d\x65")->willReturn("\x44\157\145");
        $this->customerRepository->method("\147\145\164")->with($tyorZ)->willReturn($jItv1);
        $this->twofautility->method("\x63\150\145\143\153\137\x63\165\x73\x74\x6f\x6d\107\x61\x74\145\x77\x61\x79\137\x6d\145\164\150\x6f\x64\103\157\156\x66\151\147\165\x72\x65\144")->willReturn(false);
        $this->twofautility->method("\147\145\164\x53\x74\157\x72\x65\103\157\x6e\146\x69\147")->willReturnMap([["\123\x45\x4c\x45\x43\124\105\104\137\124\x45\x4d\x50\x4c\x41\124\105\x5f\111\x44", null, "\x74\145\x6d\160\x6c\x61\164\x65\137\151\x64"], ["\x43\x55\x53\124\x4f\x4d\x47\x41\x54\105\x57\x41\x59\137\x45\115\x41\x49\x4c\137\106\122\117\x4d", null, "\146\162\x6f\155\100\x65\170\141\x6d\x70\154\145\56\143\157\155"], ["\x43\x55\123\x54\x4f\115\x47\101\x54\105\127\x41\131\x5f\x45\115\101\111\114\x5f\x4e\101\115\x45", null, "\123\x65\156\x64\x65\162\116\141\155\x65"]]);
        $this->escaper->method("\x65\163\143\141\160\x65\x48\164\155\154")->willReturnArgument(0);
        $this->storeManager->method("\x67\x65\164\x53\x74\157\x72\145")->willReturn($P9ID7);
        $this->transportBuilder->method("\163\145\164\x54\145\x6d\x70\154\x61\164\x65\x49\144\145\156\x74\151\x66\x69\x65\x72")->willReturnSelf();
        $this->transportBuilder->method("\x73\x65\164\x54\145\155\160\154\x61\x74\x65\117\x70\164\x69\x6f\156\163")->willReturnSelf();
        $this->transportBuilder->method("\163\x65\164\x54\145\x6d\160\154\141\x74\x65\x56\141\x72\163")->willReturnSelf();
        $this->transportBuilder->method("\x73\145\x74\106\x72\x6f\x6d")->willReturnSelf();
        $this->transportBuilder->method("\x61\144\x64\x54\x6f")->willReturnSelf();
        $this->transportBuilder->method("\x67\x65\164\x54\x72\141\156\x73\x70\157\x72\x74")->willReturn($e8Ud6);
        $e8Ud6->expects($this->once())->method("\x73\x65\x6e\x64\115\x65\163\163\141\147\145");
        $this->twofautility->expects($this->atLeastOnce())->method("\154\x6f\x67\x5f\144\145\x62\165\x67");
        $OL73U = $this->customEmail->sendCustomgatewayEmail($tyorZ, $A2Q8p);
        $this->assertEquals("\x53\x55\x43\103\105\x53\123", $OL73U["\163\x74\x61\x74\165\x73"]);
        $this->assertStringContainsString("\x54\150\145\40\x4f\x54\120\x20\150\x61\163\x20\x62\145\145\x6e\40\x73\x65\x6e\164\40\164\x6f", $OL73U["\155\x65\x73\x73\x61\147\x65"]);
    }
    public function testSendCustomgatewayEmailCustomGatewayNotConfigured()
    {
        $tyorZ = "\x75\163\145\162\100\145\170\x61\x6d\160\x6c\x65\x2e\x63\x6f\x6d";
        $A2Q8p = "\x31\x32\63\64\65\x36";
        $this->twofautility->method("\143\x68\x65\x63\153\x5f\143\165\x73\164\x6f\x6d\107\141\x74\145\167\x61\x79\137\x6d\x65\164\x68\x6f\x64\x43\x6f\156\146\x69\x67\165\162\145\x64")->willReturn(true);
        $OL73U = $this->customEmail->sendCustomgatewayEmail($tyorZ, $A2Q8p);
        $this->assertEquals("\x46\x41\111\x4c\x45\104", $OL73U["\x73\164\141\x74\x75\x73"]);
        $this->assertStringContainsString("\x4e\157\x20\143\x75\x73\x74\x6f\x6d\x20\147\141\x74\x65\x77\x61\171\40\x6d\145\x74\150\x6f\x64\40\143\157\156\146\151\147\165\x72\145\144", $OL73U["\155\x65\163\x73\141\147\x65"]);
    }
    public function testSendCustomgatewayEmailExceptionThrown()
    {
        $tyorZ = "\165\x73\145\162\100\x65\x78\x61\x6d\160\x6c\145\56\x63\157\x6d";
        $A2Q8p = "\61\x32\63\x34\x35\x36";
        $P9ID7 = $this->createMock(StoreInterface::class);
        $jItv1 = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);
        $jItv1->method("\x67\x65\x74\x46\x69\162\163\x74\x6e\141\x6d\x65")->willReturn("\112\157\x68\156");
        $jItv1->method("\x67\x65\x74\x4c\141\163\164\156\141\155\x65")->willReturn("\104\157\145");
        $this->customerRepository->method("\147\145\164")->with($tyorZ)->willReturn($jItv1);
        $this->twofautility->method("\x63\x68\x65\x63\x6b\137\x63\165\163\164\157\x6d\x47\x61\164\x65\x77\x61\x79\137\155\x65\164\x68\157\144\x43\157\x6e\x66\x69\x67\x75\x72\x65\x64")->willReturn(false);
        $this->twofautility->method("\147\145\x74\123\x74\x6f\x72\x65\x43\x6f\156\x66\x69\x67")->willReturn("\166\x61\x6c");
        $this->escaper->method("\x65\163\143\141\160\x65\x48\x74\x6d\x6c")->willReturnArgument(0);
        $this->storeManager->method("\x67\145\x74\123\x74\157\162\145")->willReturn($P9ID7);
        $this->transportBuilder->method("\163\x65\164\124\x65\x6d\160\154\141\164\x65\111\144\145\x6e\x74\151\x66\x69\x65\162")->willReturnSelf();
        $this->transportBuilder->method("\x73\145\164\x54\145\x6d\x70\154\x61\x74\x65\x4f\x70\164\x69\x6f\156\163")->willReturnSelf();
        $this->transportBuilder->method("\x73\x65\164\x54\x65\x6d\160\154\141\164\x65\126\141\162\x73")->willReturnSelf();
        $this->transportBuilder->method("\163\145\x74\x46\162\x6f\155")->willReturnSelf();
        $this->transportBuilder->method("\x61\144\144\124\157")->willReturnSelf();
        $this->transportBuilder->method("\x67\x65\164\124\x72\141\156\163\160\157\x72\164")->willThrowException(new \Exception("\x54\x72\141\156\x73\x70\157\x72\x74\40\x65\162\x72\x6f\x72"));
        $this->twofautility->expects($this->atLeastOnce())->method("\x6c\x6f\x67\x5f\x64\145\x62\x75\147");
        $OL73U = $this->customEmail->sendCustomgatewayEmail($tyorZ, $A2Q8p);
        $this->assertEquals("\106\x41\x49\x4c\105\104", $OL73U["\163\x74\x61\164\165\163"]);
        $this->assertStringContainsString("\106\141\x6c\151\145\144\40\164\157\40\163\145\156\144\x20\117\x54\120", $OL73U["\155\x65\163\x73\141\x67\145"]);
        $this->assertStringContainsString("\124\x72\x61\156\x73\x70\x6f\x72\x74\40\145\162\162\x6f\x72", $OL73U["\x74\145\x63\150\x5f\x6d\x65\163\x73\141\147\x65"]);
    }
    public function testSendCustomgatewayEmailInvalidEmailFormat()
    {
        $tyorZ = "\x69\x6e\x76\x61\154\151\144\145\x6d\x61\x69\154";
        $A2Q8p = "\x31\x32\63\64\65\x36";
        $P9ID7 = $this->createMock(StoreInterface::class);
        $e8Ud6 = $this->createMock(TransportInterface::class);
        $jItv1 = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);
        $jItv1->method("\x67\x65\x74\x46\x69\x72\x73\x74\156\141\155\145")->willReturn("\x4a\157\150\x6e");
        $jItv1->method("\147\145\x74\x4c\x61\x73\164\x6e\x61\155\x65")->willReturn("\104\x6f\x65");
        $this->customerRepository->method("\147\145\164")->with($tyorZ)->willReturn($jItv1);
        $this->twofautility->method("\x63\x68\x65\143\x6b\137\143\x75\x73\x74\x6f\155\107\141\164\x65\x77\141\x79\137\x6d\x65\x74\150\x6f\x64\103\157\156\x66\x69\147\x75\162\x65\144")->willReturn(false);
        $this->twofautility->method("\x67\x65\164\x53\x74\x6f\x72\x65\103\x6f\x6e\146\151\x67")->willReturn("\166\141\154");
        $this->escaper->method("\145\163\x63\141\160\145\x48\164\155\154")->willReturnArgument(0);
        $this->storeManager->method("\147\145\164\x53\164\157\x72\145")->willReturn($P9ID7);
        $this->transportBuilder->method("\x73\x65\164\124\x65\155\160\154\141\164\x65\111\x64\145\156\164\151\x66\151\x65\162")->willReturnSelf();
        $this->transportBuilder->method("\163\145\x74\124\x65\x6d\160\154\x61\164\145\117\160\164\x69\157\156\x73")->willReturnSelf();
        $this->transportBuilder->method("\x73\145\x74\124\145\x6d\160\154\x61\x74\145\126\141\162\163")->willReturnSelf();
        $this->transportBuilder->method("\x73\145\x74\x46\162\x6f\155")->willReturnSelf();
        $this->transportBuilder->method("\x61\x64\144\x54\157")->willReturnSelf();
        $this->transportBuilder->method("\x67\145\x74\x54\x72\141\156\163\x70\157\x72\164")->willReturn($e8Ud6);
        $e8Ud6->expects($this->once())->method("\163\145\156\144\x4d\145\163\x73\x61\x67\145");
        $this->twofautility->expects($this->atLeastOnce())->method("\x6c\x6f\147\137\x64\145\x62\x75\x67");
        $OL73U = $this->customEmail->sendCustomgatewayEmail($tyorZ, $A2Q8p);
        $this->assertEquals("\123\125\103\103\x45\123\x53", $OL73U["\x73\164\x61\x74\165\163"]);
        $this->assertStringContainsString("\124\x68\x65\x20\x4f\x54\120\40\150\x61\163\x20\x62\145\145\156\40\163\x65\156\164\x20\164\x6f\x20\151\156\x76\x61\154\151\x64\145\x6d\141\x69\154", $OL73U["\155\x65\163\x73\x61\147\x65"]);
    }
    public function testGetcustomerFullnameCustomerFound()
    {
        $tyorZ = "\165\x73\145\x72\x40\145\170\141\x6d\x70\154\145\x2e\x63\x6f\155";
        $jItv1 = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);
        $jItv1->method("\147\x65\164\x46\151\x72\x73\164\x6e\x61\155\145")->willReturn("\x4a\x6f\x68\156");
        $jItv1->method("\x67\x65\x74\114\x61\163\x74\156\141\155\145")->willReturn("\104\x6f\145");
        $this->customerRepository->method("\147\145\164")->with($tyorZ)->willReturn($jItv1);
        $OL73U = $this->customEmail->getcustomerFullname($tyorZ);
        $this->assertEquals("\112\x6f\x68\x6e\x20\104\157\145", $OL73U);
    }
    public function testGetcustomerFullnameCustomerNotFound()
    {
        $tyorZ = "\x75\163\145\x72\100\x65\x78\141\x6d\160\154\145\56\x63\157\155";
        $this->customerRepository->method("\x67\145\164")->with($tyorZ)->willThrowException(new \Magento\Framework\Exception\NoSuchEntityException(__("\116\x6f\164\x20\x66\157\x75\156\x64")));
        $OL73U = $this->customEmail->getcustomerFullname($tyorZ);
        $this->assertEquals("\x54\145\x73\164\x69\156\147", $OL73U);
    }
}