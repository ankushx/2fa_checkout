<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Advance2fa;

use Magento\Backend\App\Action\Context;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Store\Api\WebsiteRepositoryInterface;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
class Index extends BaseAdminAction implements HttpPostActionInterface, HttpGetActionInterface
{
    protected $fileFactory;
    private $websiteRepository;
    private $groupRepository;
    private $searchCriteriaBuilder;
    public function __construct(Context $tRBK6, TwoFAUtility $RI43_, \Magento\Framework\View\Result\PageFactory $iNYBK, \Magento\Framework\Message\ManagerInterface $oYV0E, \Psr\Log\LoggerInterface $k5Epm, FileFactory $sFoIj, WebsiteRepositoryInterface $tMbg6, GroupRepositoryInterface $PC2hp, SearchCriteriaBuilder $WtOP4)
    {
        parent::__construct($tRBK6, $iNYBK, $RI43_, $oYV0E, $k5Epm);
        $this->fileFactory = $sFoIj;
        $this->websiteRepository = $tMbg6;
        $this->groupRepository = $PC2hp;
        $this->searchCriteriaBuilder = $WtOP4;
    }
    public function execute()
    {
        try {
            $IiazC = $this->getRequest()->getParams();
            $fD314 = $this->twofautility->getCurrentAdminUser()->getEmail();
            $this->twofautility->isFirstPageVisit($fD314, "\62\x46\101\40\x41\x64\166\141\156\x63\145\40\123\x65\164\x74\151\x6e\x67\x73");
            if (!$this->isFormOptionBeingSaved($IiazC)) {
                goto wlKpJ;
            }
            $this->processValuesAndSaveData($IiazC);
            $this->twofautility->flushCache();
            $this->messageManager->addSuccessMessage(TwoFAMessages::SETTINGS_SAVED);
            $this->twofautility->reinitConfig();
            wlKpJ:
        } catch (\Exception $U47L0) {
            $this->messageManager->addErrorMessage($U47L0->getMessage());
            $this->logger->debug($U47L0->getMessage());
        }
        $MC6C3 = $this->resultPageFactory->create();
        $MC6C3->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $MC6C3;
    }
    private function processValuesAndSaveData($IiazC)
    {
        $aHUQB = $this->twofautility->isCustomerRegistered();
        if ($aHUQB) {
            goto Osmwm;
        }
        $this->messageManager->addErrorMessage(TwoFAMessages::NOT_REGISTERED);
        $lXKXC = $this->resultRedirectFactory->create();
        $lXKXC->setPath("\x6d\157\164\x77\x6f\146\141\x2f\x61\x63\143\157\x75\156\x74\x2f\x69\156\x64\x65\170");
        return $lXKXC;
        Osmwm:
        $this->twofautility->log_debug("\124\x77\x6f\x46\x41\40\123\151\x67\156\40\x69\156\40\x53\x65\x74\164\151\156\x67\163\x20\x63\x68\141\x6e\147\x65\144\40\x62\171\x20\x74\150\145\x20\146\157\x6c\x6c\x6f\167\151\x6e\147\x20\141\144\x6d\151\x6e");
        if (!(isset($IiazC["\157\x70\x74\x69\157\156"]) && $IiazC["\x6f\160\164\151\157\156"] == "\141\144\x76\x61\x6e\x63\145\x5f\163\x61\x76\x65\123\145\164\164\151\x6e\147\163")) {
            goto lwh8C;
        }
        lwh8C:
        $aO4Bn = isset($IiazC["\x63\165\x73\164\x6f\x6d\145\x72\x5f\x72\145\155\145\155\x62\145\162\x5f\144\145\166\x69\143\145"]) ? 1 : 0;
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE, (int) $aO4Bn);
        if (isset($IiazC["\143\165\x73\x74\x6f\x6d\x65\162\x5f\x72\x65\155\145\155\142\x65\162\137\144\145\x76\151\143\x65"])) {
            goto x0tiu;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_COUNT, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_LIMIT, NULL);
        goto NEJZ3;
        x0tiu:
        if (!isset($IiazC["\x63\165\163\x74\157\x6d\145\x72\137\144\x65\166\151\x63\145\137\143\157\165\x6e\164"])) {
            goto RdzJW;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_COUNT, $IiazC["\x63\x75\163\x74\x6f\x6d\145\162\x5f\144\145\166\x69\x63\145\137\x63\157\x75\x6e\x74"]);
        RdzJW:
        if (!isset($IiazC["\x63\x75\x73\164\x6f\x6d\x65\162\137\x72\145\155\145\155\142\145\x72\137\x64\x65\166\151\143\145\x5f\104\x61\x79\163"])) {
            goto bQIqC;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_LIMIT, $IiazC["\x63\165\x73\x74\157\x6d\x65\162\137\162\145\155\145\x6d\142\145\162\137\144\x65\x76\x69\143\145\137\x44\141\x79\x73"]);
        bQIqC:
        NEJZ3:
        $dyyFj = isset($IiazC["\143\165\163\164\x6f\155\x65\x72\137\163\x6b\x69\160\137\x69\156\154\151\156\145"]) ? 1 : 0;
        $Gfnwa = isset($IiazC["\143\x75\x73\x74\157\155\x65\162\137\x65\x6e\141\x62\x6c\x65\137\x63\x61\x72\164\x41\155\157\x75\156\x74"]) ? $IiazC["\x63\165\163\x74\x6f\155\x65\x72\x5f\x65\x6e\141\142\154\x65\x5f\x63\141\x72\x74\101\x6d\157\x75\156\x74"] : NULL;
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_CART_AMOUNT, $Gfnwa);
        if (isset($IiazC["\143\165\163\x74\x6f\x6d\145\162\x5f\x65\156\141\142\154\145\x5f\x63\141\162\164\x41\x6d\x6f\x75\x6e\164"])) {
            goto kFNrf;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_MINIMUM_CART_AMOUNT, NULL);
        goto jDout;
        kFNrf:
        if (!isset($IiazC["\x63\x75\163\x74\x6f\155\x65\x72\x5f\x6d\151\156\151\155\x75\155\x5f\143\x61\x72\164\x5f\x61\155\x6f\165\156\x74"])) {
            goto mw1iU;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_MINIMUM_CART_AMOUNT, $IiazC["\143\x75\x73\x74\157\x6d\x65\x72\137\x6d\151\x6e\x69\155\x75\x6d\x5f\x63\x61\x72\164\x5f\x61\155\157\x75\156\x74"]);
        mw1iU:
        jDout:
        $u55eS = isset($IiazC["\143\165\x73\164\x6f\155\x65\x72\x5f\145\156\x61\x62\x6c\x65\137\x61\154\164\x65\162\156\x61\164\x65\137\x32\x66\141\137\x6d\145\x74\150\157\144"]) ? $IiazC["\x63\165\163\x74\157\155\145\162\137\x65\156\x61\142\154\x65\137\141\x6c\164\145\162\x6e\x61\x74\145\x5f\x32\146\x61\137\155\145\x74\x68\x6f\144"] : NULL;
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_ALTERNATE_2FA_METHOD, $u55eS);
        if (isset($IiazC["\143\165\163\164\157\155\145\162\137\145\x6e\x61\142\x6c\x65\137\x61\x6c\164\145\162\156\x61\x74\x65\x5f\62\x66\x61\x5f\155\145\164\x68\157\x64"])) {
            goto HStjG;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_ALTERNATE_2FA_METHOD, NULL);
        goto BrMLr;
        HStjG:
        if (!isset($IiazC["\x63\165\163\x74\x6f\155\145\x72\x5f\x61\154\x74\145\x72\156\141\x74\x65\137\62\146\141\137\155\145\164\x68\157\x64\x73"])) {
            goto CC8pn;
        }
        $IOrNs = $IiazC["\x63\x75\x73\164\157\x6d\145\x72\x5f\141\154\164\145\x72\x6e\141\x74\x65\x5f\62\x66\x61\x5f\x6d\145\164\150\157\x64\163"];
        $vNxJL = json_encode($IOrNs);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_ALTERNATE_2FA_METHOD, $vNxJL);
        CC8pn:
        BrMLr:
        $pkofc = isset($IiazC["\143\165\163\164\157\x6d\145\x72\x5f\x65\x6e\x61\142\154\145\x5f\x62\154\157\x63\x6b\x5f\x73\x70\141\155\x5f\160\x68\157\156\145\137\156\165\x6d\x62\x65\x72"]) ? $IiazC["\x63\165\x73\164\157\155\x65\x72\137\145\x6e\x61\142\154\145\137\x62\x6c\x6f\x63\x6b\x5f\163\160\x61\x6d\x5f\160\x68\157\x6e\145\137\x6e\165\155\142\x65\x72"] : NULL;
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_BLOCK_SPAM_PHONE_NUMBER, $pkofc);
        if (isset($IiazC["\x63\165\163\164\x6f\x6d\145\x72\137\x65\156\141\142\154\x65\x5f\x62\x6c\x6f\x63\x6b\137\x73\x70\x61\155\x5f\x70\150\157\x6e\145\x5f\x6e\x75\155\x62\145\162"])) {
            goto Afxol;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_BLOCK_SPAM_PHONE_NUMBER, NULL);
        goto a_Ary;
        Afxol:
        if (!isset($IiazC["\x63\165\163\164\157\x6d\x65\162\137\x62\x6c\x6f\x63\153\137\x73\x70\141\155\137\160\150\x6f\x6e\145\x5f\x6e\165\155\x62\x65\x72"])) {
            goto iTjMx;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_BLOCK_SPAM_PHONE_NUMBER, $IiazC["\x63\x75\163\x74\157\x6d\x65\162\x5f\142\154\x6f\x63\153\137\163\160\141\155\137\x70\x68\157\x6e\145\137\x6e\165\155\x62\145\x72"]);
        iTjMx:
        a_Ary:
        $this->twofautility->setStoreConfig(TwoFAConstants::SKIP_TWOFA, (int) $dyyFj);
        if (isset($IiazC["\x63\x75\x73\164\157\155\x65\x72\137\x73\x6b\x69\x70\x5f\151\x6e\x6c\x69\x6e\145"])) {
            goto qhjHH;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::SKIP_TWOFA_DAYS, NULL);
        goto zpA5r;
        qhjHH:
        if (!(isset($IiazC["\143\x75\163\x74\157\155\x65\162\x5f\x73\x6b\151\x70\137\x64\141\x79\163"]) && $IiazC["\x63\165\x73\164\157\155\145\x72\137\x73\153\151\160\x5f\144\141\x79\163"] != '')) {
            goto ZqKHY;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::SKIP_TWOFA_DAYS, $IiazC["\143\x75\x73\164\x6f\155\145\x72\x5f\163\153\151\x70\x5f\x64\x61\x79\163"]);
        ZqKHY:
        zpA5r:
        $q5rII = isset($IiazC["\143\x75\x73\x74\x6f\155\x65\x72\x5f\160\157\160\x75\x70\x5f\x63\x75\x73\x74\157\155\x69\172\141\x74\x69\157\156"]) ? 1 : 0;
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_POPUP_CUSTOMIZATION, (int) $q5rII);
        if (isset($IiazC["\143\165\163\x74\157\x6d\x65\x72\x5f\160\157\160\x75\160\x5f\143\x75\x73\x74\157\155\x69\x7a\141\164\151\x6f\156"])) {
            goto sIVVj;
        }
        $MfuFF = array("\x42\147\103\x6f\x6c\157\x72" => "\43\x66\146\146\146\146\146", "\x70\157\x70\x75\160\x42\147\103\x6f\x6c\x6f\162" => "\43\x66\x66\x66\x66\146\146", "\x70\x6f\160\165\x70\x54\x65\170\x74\x43\157\x6c\x6f\x72" => "\x23\60\60\60\x30\60\60", "\160\x6f\160\x75\x70\x42\164\156\x43\157\154\x6f\162" => "\x23\146\146\70\x35\x30\x30");
        $VqfW8 = json_encode($MfuFF);
        $this->twofautility->setStoreConfig(TwoFAConstants::POP_UI_VALUES, $VqfW8);
        goto kWrQs;
        sIVVj:
        $MfuFF = array("\102\x67\103\157\x6c\157\162" => $IiazC["\x42\147\x43\157\x6c\x6f\x72"], "\160\x6f\x70\x75\x70\x42\x67\103\x6f\154\x6f\x72" => $IiazC["\160\157\x70\x75\160\102\x67\x43\157\154\x6f\x72"], "\x70\x6f\x70\165\x70\124\x65\x78\x74\x43\x6f\x6c\x6f\162" => $IiazC["\x70\157\x70\x75\160\124\145\x78\164\103\x6f\x6c\x6f\x72"], "\160\157\x70\x75\x70\x42\x74\x6e\103\x6f\154\157\162" => $IiazC["\x70\x6f\160\165\160\102\164\x6e\103\157\154\x6f\162"]);
        $VqfW8 = json_encode($MfuFF);
        $this->twofautility->setStoreConfig(TwoFAConstants::POP_UI_VALUES, $VqfW8);
        kWrQs:
        $C6jzN = isset($IiazC["\x63\165\x73\x74\x6f\155\x65\162\x5f\151\160\137\x6c\151\x73\164\x69\156\147"]) ? 1 : 0;
        $this->twofautility->setStoreConfig(TwoFAConstants::IP_LISTING, (int) $C6jzN);
        if (!$C6jzN) {
            goto BNSEp;
        }
        $y2zb3 = [];
        $uhhkZ = [];
        if (!isset($IiazC["\167\x68\151\x74\145\154\151\163\x74\111\x50\163"])) {
            goto DUdy3;
        }
        $uhhkZ = json_decode($IiazC["\x77\150\x69\x74\x65\x6c\x69\163\164\x49\x50\x73"], true);
        if (is_array($uhhkZ)) {
            goto uJ7KL;
        }
        $uhhkZ = [];
        uJ7KL:
        $this->twofautility->setStoreConfig(TwoFAConstants::ALL_IP_WHITLISTED, json_encode($uhhkZ));
        DUdy3:
        if (!isset($IiazC["\x62\x6c\141\x63\153\x6c\x69\163\164\x49\x50\163"])) {
            goto xv7bs;
        }
        $y2zb3 = json_decode($IiazC["\142\154\x61\143\153\154\x69\x73\x74\x49\120\163"], true);
        if (is_array($y2zb3)) {
            goto rFUzp;
        }
        $y2zb3 = [];
        rFUzp:
        $y2zb3 = array_diff($y2zb3, $uhhkZ);
        $this->twofautility->setStoreConfig(TwoFAConstants::ALL_IP_BLACKLISTED, json_encode($y2zb3));
        xv7bs:
        BNSEp:
        if (!isset($IiazC["\157\x74\160\137\154\x65\156\147\x74\150"])) {
            goto TZEGZ;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::ADVANCED_OTP_LENGTH, (int) $IiazC["\157\x74\160\137\x6c\x65\x6e\x67\164\150"]);
        TZEGZ:
        $zZO8q = isset($IiazC["\x61\x75\x74\150\145\x6e\164\x69\143\141\164\x6f\162\137\141\160\160\x5f\x6e\x61\155\x65\x5f\x65\x6e\141\142\154\145\x64"]) ? 1 : 0;
        $this->twofautility->setStoreConfig(TwoFAConstants::AUTHENTICATOR_APP_NAME_ENABLED, (int) $zZO8q);
        if ($zZO8q && isset($IiazC["\141\165\x74\150\x65\156\x74\x69\x63\141\164\x6f\162\x5f\x61\160\160\x5f\156\141\x6d\145"])) {
            goto ymLH2;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::AUTHENTICATOR_APP_NAME, "\x6d\x69\156\x69\117\x72\141\156\x67\145");
        goto cdgZ4;
        ymLH2:
        $x0jFR = trim($IiazC["\141\165\x74\150\145\156\x74\151\x63\x61\x74\x6f\162\x5f\x61\x70\160\x5f\156\141\x6d\x65"]);
        if (!empty($x0jFR)) {
            goto x4yxc;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::AUTHENTICATOR_APP_NAME, "\x6d\x69\x6e\151\117\162\x61\x6e\147\x65");
        goto q_FkK;
        x4yxc:
        $this->twofautility->setStoreConfig(TwoFAConstants::AUTHENTICATOR_APP_NAME, $x0jFR);
        q_FkK:
        cdgZ4:
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_ADVANCE_2FA);
    }
}