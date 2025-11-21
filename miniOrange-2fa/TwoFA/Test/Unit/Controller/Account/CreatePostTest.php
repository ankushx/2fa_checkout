<?php

namespace Magento\Newsletter\Model;

if (class_exists("\115\x61\147\x65\x6e\164\157\x5c\116\x65\x77\x73\x6c\145\164\164\145\x72\134\115\x6f\144\145\x6c\134\123\x75\x62\x73\x63\x72\x69\142\145\162\106\141\x63\164\x6f\x72\x79")) {
    goto o47lh;
}
class SubscriberFactory
{
}
o47lh:
namespace MiniOrange\TwoFA\Test\Unit\Controller\Account;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Helper\Address;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Metadata\FormFactory;
use Magento\Customer\Model\Registration;
use Magento\Customer\Model\Url;
use Magento\Customer\Model\CustomerExtractor;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Escaper;
use Magento\Customer\Api\Data\RegionInterfaceFactory;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Newsletter\Model\SubscriberFactory;
use MiniOrange\TwoFA\Controller\Account\CreatePost;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\TwoFACustomerRegistration;
use Magento\Framework\Module\Manager;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
class CreatePostTest extends TestCase
{
    private $controller;
    private $context;
    private $customerSession;
    private $resultFactoryMock;
    private $redirectMock;
    private $urlMock;
    private $twoFAUtilityMock;
    private $customerModelMock;
    private $requestMock;
    private $subscriberFactory;
    private $storeManagerMock;
    private $storeMock;
    private $resultRedirectFactoryMock;
    protected function setUp() : void
    {
        $this->resultFactoryMock = $this->createMock(ResultFactory::class);
        $this->redirectMock = $this->createMock(Redirect::class);
        $this->urlMock = $this->createMock(UrlInterface::class);
        $this->twoFAUtilityMock = $this->createMock(TwoFAUtility::class);
        $this->customerModelMock = $this->createMock(Customer::class);
        $this->requestMock = $this->createMock(RequestInterface::class);
        $this->context = $this->createMock(Context::class);
        $this->context->method("\147\145\x74\122\145\x71\x75\145\x73\164")->willReturn($this->requestMock);
        $this->subscriberFactory = $this->createMock(SubscriberFactory::class);
        $this->customerSession = $this->createMock(Session::class);
        $this->scopeConfigMock = $this->createMock(ScopeConfigInterface::class);
        $this->accountManagementMock = $this->createMock(AccountManagementInterface::class);
        $this->addressHelperMock = $this->createMock(Address::class);
        $this->urlFactoryMock = $this->createMock(\Magento\Framework\UrlFactory::class);
        $this->formFactoryMock = $this->createMock(FormFactory::class);
        $this->regionInterfaceFactoryMock = $this->createMock(RegionInterfaceFactory::class);
        $this->addressInterfaceFactoryMock = $this->createMock(AddressInterfaceFactory::class);
        $this->customerInterfaceFactoryMock = $this->createMock(CustomerInterfaceFactory::class);
        $this->customerUrlMock = $this->createMock(Url::class);
        $this->registrationMock = $this->createMock(Registration::class);
        $this->escaperMock = $this->createMock(Escaper::class);
        $this->customerExtractorMock = $this->createMock(CustomerExtractor::class);
        $this->dataObjectHelperMock = $this->createMock(DataObjectHelper::class);
        $this->accountRedirectMock = $this->createMock(AccountRedirect::class);
        $this->formKeyValidatorMock = $this->createMock(Validator::class);
        $this->customEmailMock = $this->createMock(CustomEmail::class);
        $this->customSMSMock = $this->createMock(CustomSMS::class);
        $this->cookieManagerMock = $this->createMock(CookieManagerInterface::class);
        $this->cookieMetadataFactoryMock = $this->createMock(CookieMetadataFactory::class);
        $this->moduleManagerMock = $this->createMock(Manager::class);
        $this->customerRepositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $this->twoFACustomerRegistrationMock = $this->createMock(TwoFACustomerRegistration::class);
        $this->resultRedirectFactoryMock = $this->createMock(RedirectFactory::class);
        $this->resultFactoryMock->method("\x63\162\145\x61\x74\145")->with(ResultFactory::TYPE_REDIRECT)->willReturn($this->redirectMock);
        $this->resultRedirectFactoryMock->method("\x63\x72\145\x61\x74\x65")->willReturn($this->redirectMock);
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->storeMock = $this->createMock(\Magento\Store\Model\Store::class);
        $this->storeMock->method("\147\x65\164\x57\145\142\163\x69\x74\145\x49\144")->willReturn(1);
        $this->storeManagerMock->method("\147\x65\164\x53\164\x6f\x72\145")->willReturn($this->storeMock);
        $this->customerModelMock->method("\x6c\157\141\144\x42\x79\x45\x6d\x61\x69\x6c")->willReturnSelf();
        $this->customerModelMock->method("\147\145\x74\111\144")->willReturn(123);
        $this->requestMock->method("\x67\x65\x74\x50\141\x72\x61\155\163")->willReturn(["\145\155\x61\x69\x6c" => "\x74\x65\163\x74\100\x65\170\x61\155\160\154\145\x2e\x63\x6f\155"]);
        $Suwsp = new ObjectManager($this);
        $this->controller = $Suwsp->getObject(CreatePost::class, ["\x63\x6f\156\x74\x65\x78\x74" => $this->context, "\x63\x75\163\x74\x6f\155\145\x72\123\x65\x73\x73\151\157\x6e" => $this->customerSession, "\163\x63\157\x70\x65\x43\x6f\156\x66\x69\x67" => $this->scopeConfigMock, "\163\164\157\x72\x65\115\x61\156\x61\147\x65\x72" => $this->storeManagerMock, "\141\x63\143\157\165\x6e\164\x4d\x61\x6e\141\x67\x65\155\145\156\164" => $this->accountManagementMock, "\x61\x64\144\162\145\x73\x73\x48\145\x6c\160\145\162" => $this->addressHelperMock, "\165\162\x6c\x46\x61\x63\164\x6f\162\171" => $this->urlFactoryMock, "\146\x6f\162\x6d\106\141\x63\x74\157\x72\171" => $this->formFactoryMock, "\163\165\x62\163\x63\162\151\142\145\162\106\141\x63\x74\x6f\162\x79" => $this->subscriberFactory, "\x72\145\147\151\x6f\x6e\x44\141\x74\x61\x46\x61\x63\164\157\x72\171" => $this->regionInterfaceFactoryMock, "\x61\144\144\162\145\x73\163\x44\x61\x74\x61\106\141\143\164\x6f\162\171" => $this->addressInterfaceFactoryMock, "\143\165\x73\x74\x6f\x6d\145\162\104\141\164\141\106\x61\x63\x74\157\162\171" => $this->customerInterfaceFactoryMock, "\143\x75\x73\x74\x6f\155\x65\162\x55\x72\154" => $this->customerUrlMock, "\162\x65\147\x69\163\x74\x72\141\164\151\x6f\x6e" => $this->registrationMock, "\145\163\143\141\160\x65\x72" => $this->escaperMock, "\x63\165\x73\164\157\x6d\145\x72\x45\170\x74\x72\141\x63\x74\157\x72" => $this->customerExtractorMock, "\144\141\164\141\117\142\152\145\x63\164\x48\x65\x6c\x70\145\x72" => $this->dataObjectHelperMock, "\141\143\143\x6f\x75\x6e\x74\x52\x65\144\151\x72\x65\143\x74" => $this->accountRedirectMock, "\146\157\162\155\113\x65\171\x56\141\x6c\x69\x64\141\164\157\162" => $this->formKeyValidatorMock, "\x63\x75\x73\x74\x6f\155\x45\x6d\x61\x69\x6c" => $this->customEmailMock, "\x63\x75\x73\164\157\155\x53\115\123" => $this->customSMSMock, "\x54\x77\x6f\106\101\125\x74\x69\154\x69\x74\x79" => $this->twoFAUtilityMock, "\x72\x65\x73\x75\154\164\106\x61\x63\x74\157\162\x79" => $this->resultFactoryMock, "\x63\157\x6f\x6b\151\145\115\x61\x6e\x61\x67\145\162" => $this->cookieManagerMock, "\x63\157\157\x6b\x69\145\x4d\145\x74\141\x64\x61\164\x61\x46\x61\x63\x74\x6f\x72\x79" => $this->cookieMetadataFactoryMock, "\x6d\157\x64\x75\x6c\145\x4d\141\x6e\x61\x67\145\x72" => $this->moduleManagerMock, "\x75\x72\154" => $this->urlMock, "\143\x75\163\x74\157\155\145\162\x52\145\160\x6f\x73\x69\x74\157\162\171" => $this->customerRepositoryMock, "\143\x75\163\x74\x6f\x6d\x65\162\x4d\157\x64\145\x6c" => $this->customerModelMock, "\124\167\x6f\x46\x41\103\165\163\164\x6f\155\145\x72\x52\x65\x67\151\163\x74\x72\x61\164\x69\157\x6e" => $this->twoFACustomerRegistrationMock, "\x72\145\163\165\154\x74\x52\145\x64\x69\x72\x65\x63\164\106\x61\143\164\x6f\162\x79" => $this->resultRedirectFactoryMock]);
        $mTGF6 = new \ReflectionObject($this->controller);
        HD68V:
        if (!($mTGF6 = $mTGF6->getParentClass())) {
            goto nTBpd;
        }
        if (!$mTGF6->hasProperty("\162\145\x73\x75\x6c\164\106\x61\143\x74\x6f\x72\171")) {
            goto K_0tM;
        }
        $tn42M = $mTGF6->getProperty("\x72\145\x73\x75\x6c\164\x46\141\143\164\x6f\162\x79");
        $tn42M->setAccessible(true);
        $tn42M->setValue($this->controller, $this->resultFactoryMock);
        K_0tM:
        if (!$mTGF6->hasProperty("\x72\x65\x73\x75\154\x74\x52\145\x64\151\162\x65\x63\164\x46\141\x63\x74\x6f\x72\x79")) {
            goto h07g8;
        }
        $tn42M = $mTGF6->getProperty("\162\145\163\165\x6c\x74\x52\x65\144\151\162\145\143\x74\106\x61\143\164\x6f\x72\x79");
        $tn42M->setAccessible(true);
        $tn42M->setValue($this->controller, $this->resultRedirectFactoryMock);
        h07g8:
        goto HD68V;
        nTBpd:
    }
    public function testExecuteRedirectsWhenCustomerExists()
    {
        $Re3rc = "\164\145\x73\164\x40\145\x78\x61\x6d\160\x6c\x65\x2e\143\x6f\x6d";
        $bZIuj = 1;
        $this->requestMock->method("\147\145\164\120\141\x72\141\155\163")->willReturn(["\145\x6d\141\151\x6c" => $Re3rc]);
        $this->customerModelMock->method("\154\157\x61\x64\x42\171\105\155\x61\151\x6c")->with($Re3rc)->willReturnSelf();
        $this->customerModelMock->method("\147\x65\164\111\144")->willReturn($bZIuj);
        $this->twoFAUtilityMock->method("\x67\x65\x74\123\x74\157\162\x65\x43\157\x6e\x66\151\x67")->willReturn(true);
        $this->twoFAUtilityMock->method("\143\x68\x65\x63\153\62\x66\141\x5f\145\156\164\x65\162\160\162\x69\163\x65\x50\154\141\x6e")->willReturn(true);
        $this->twoFAUtilityMock->method("\x63\x68\x65\143\153\111\x50\x73")->willReturn(false);
        $hXPzo = $this->controller->execute();
        $this->assertSame($this->redirectMock, $hXPzo);
    }
    public function testExecuteFallsBackToParentExecuteWhenTwoFANotEnabled()
    {
        $this->requestMock->method("\x67\145\x74\x50\x61\x72\x61\x6d\x73")->willReturn(["\145\x6d\141\x69\x6c" => "\156\157\x32\x66\141\x40\x65\170\x61\x6d\160\154\145\56\x63\x6f\155"]);
        $this->twoFAUtilityMock->method("\x67\x65\x74\123\164\157\x72\x65\x43\157\x6e\146\x69\x67")->willReturn(false);
        $hXPzo = $this->controller->execute();
        $this->assertSame($this->redirectMock, $hXPzo);
    }
}