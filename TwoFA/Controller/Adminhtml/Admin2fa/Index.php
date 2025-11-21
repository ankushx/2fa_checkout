<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Admin2fa;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\Curl;
class Index extends BaseAdminAction implements HttpPostActionInterface, HttpGetActionInterface
{
    private $adminRoleModel;
    private $currentAdminUser;
    protected $currentAdmin;
    public function __construct(Context $GtrHz, TwoFAUtility $dT6s9, PageFactory $ecgo9, \Magento\Framework\Message\ManagerInterface $HEO0l, \Psr\Log\LoggerInterface $FdXB4, \Magento\Authorization\Model\ResourceModel\Role\Collection $FHefg)
    {
        parent::__construct($GtrHz, $ecgo9, $dT6s9, $HEO0l, $FdXB4);
        $this->adminRoleModel = $FHefg;
    }
    public function execute()
    {
        try {
            $AvhxZ = $this->getRequest()->getParams();
            $this->currentAdmin = $this->twofautility->getCurrentAdminUser();
            $this->currentAdminUser = $this->currentAdmin->getUsername();
            if (!$this->isFormOptionBeingSaved($AvhxZ)) {
                goto MQWpo;
            }
            $this->processSignInSettings($AvhxZ);
            $this->messageManager->addSuccessMessage(TwoFAMessages::SETTINGS_SAVED);
            $UxToC = $this->twofautility->getAdminUrl("\x6d\x6f\164\167\157\146\x61\x2f\x74\146\141\x73\145\164\x74\x69\156\x67\163\x63\x6f\156\146\151\147\x75\162\x61\164\x69\157\x6e\x74\x61\142\154\145\x2f\x69\156\x64\x65\170");
            return $this->resultRedirectFactory->create()->setUrl($UxToC);
            MQWpo:
        } catch (Exception $TDZck) {
            $this->messageManager->addErrorMessage(__("\101\x6e\40\145\162\162\157\162\x20\157\143\143\165\x72\162\145\144\72\x20\x25\x31", $TDZck->getMessage()));
            $this->logger->debug($TDZck->getMessage());
        }
        $vqRJB = $this->resultPageFactory->create();
        $vqRJB->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $vqRJB;
    }
    private function processSignInSettings(array $AvhxZ)
    {
        $HzVRA = $this->twofautility->isCustomerRegistered();
        if ($HzVRA) {
            goto BP4oH;
        }
        $this->messageManager->addErrorMessage(TwoFAMessages::NOT_REGISTERED);
        $Suf9x = $this->resultRedirectFactory->create();
        $Suf9x->setPath("\x6d\x6f\164\x77\157\x66\x61\57\x61\x63\x63\157\x75\156\x74\x2f\151\156\144\x65\170");
        return $Suf9x;
        BP4oH:
        if (!(isset($AvhxZ["\x6f\x70\164\151\x6f\156"]) && $AvhxZ["\157\x70\164\151\157\x6e"] === "\163\141\x76\145\x53\x69\147\156\111\x6e\123\145\164\x74\151\156\x67\163\137\141\144\155\151\156")) {
            goto bqw1l;
        }
        if (!isset($AvhxZ["\162\165\154\x65\163"])) {
            goto G1O_N;
        }
        $W8E0X = json_decode($AvhxZ["\162\x75\154\x65\163"], true);
        if (!(json_last_error() !== JSON_ERROR_NONE)) {
            goto EH3eV;
        }
        throw new Exception(__("\111\x6e\166\141\x6c\x69\x64\40\x4a\x53\117\116\x20\x69\x6e\40\162\165\154\x65\x73\40\160\x61\162\x61\x6d\145\164\x65\x72"));
        EH3eV:
        $this->twofautility->setStoreConfig(TwoFAConstants::CURRENT_ADMIN_RULE, json_encode($W8E0X));
        $MMEBb = $this->twofautility->ifSandboxTrialEnabled();
        $WKzEv = $this->twofautility->check_license_plan(4);
        if ($MMEBb) {
            goto WjhYf;
        }
        if ($WKzEv) {
            goto VdAwD;
        }
        goto JLS2s;
        WjhYf:
        $IRAej = $this->currentAdmin->getEmail();
        $CZSbj = $this->twofautility->getSandBoxUserDataUsingEmail($IRAej);
        $J0aGB = isset($CZSbj[0]["\x74\151\155\x65\x73\x74\x61\155\x70"]) ? $CZSbj[0]["\x74\151\x6d\145\x73\x74\141\x6d\160"] : null;
        $ltWOh = array_filter($W8E0X, fn($Sii_T) => $Sii_T["\141\144\155\x69\x6e"] === $this->currentAdminUser);
        if (!empty($ltWOh)) {
            goto Mnp4s;
        }
        $YEbHY = [];
        Mnp4s:
        $CqwZz = array_merge(...array_column($ltWOh, "\155\x65\x74\x68\x6f\x64\163"));
        $YEbHY = array_values(array_unique(array_column($CqwZz, "\x6d\145\164\150\x6f\x64")));
        $ZmLOV = is_array($YEbHY) ? json_encode($YEbHY) : '';
        goto JLS2s;
        VdAwD:
        $J0aGB = $this->twofautility->getStoreConfig(TwoFAConstants::TIMESTAMP);
        $CqwZz = array_merge(...array_column($W8E0X, "\x6d\145\x74\x68\x6f\x64\163"));
        $YEbHY = array_values(array_unique(array_column($CqwZz, "\155\x65\164\150\x6f\144")));
        $ZmLOV = is_array($YEbHY) ? json_encode($YEbHY) : '';
        JLS2s:
        if (!($MMEBb || $WKzEv && !is_null($J0aGB))) {
            goto eukUv;
        }
        $Ocy1X = ["\x74\151\x6d\x65\123\x74\x61\x6d\160" => $J0aGB, "\x62\141\143\x6b\145\x6e\x64\115\x65\x74\x68\x6f\x64" => $ZmLOV];
        Curl::sendUserDetailsToPortal($Ocy1X);
        eukUv:
        if (isset($AvhxZ["\x64\x65\x6c\x65\164\x65\137\162\x6f\154\x65"])) {
            goto q3NAV;
        }
        $this->applyRulesToRoles($W8E0X);
        goto WefvT;
        q3NAV:
        $this->processRoleDeletion($AvhxZ);
        WefvT:
        G1O_N:
        bqw1l:
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
    }
    private function processRoleDeletion(array $AvhxZ)
    {
        $O6Qnq = $AvhxZ["\x64\x65\x6c\145\164\x65\137\162\157\x6c\145"];
        if ($O6Qnq === "\x41\x6c\154\40\122\157\x6c\145\163") {
            goto h3Kyh;
        }
        $this->deleteRoleMethodsConfig($O6Qnq);
        goto gKcR0;
        h3Kyh:
        $y_m43 = $this->getAllAdminRoles();
        foreach ($y_m43 as $o0YTW) {
            $o0YTW = $o0YTW["\x6c\x61\x62\145\x6c"];
            $this->deleteRoleMethodsConfig($o0YTW);
            c723I:
        }
        adbOc:
        gKcR0:
    }
    private function getAllAdminRoles() : array
    {
        $G443E = $this->adminRoleModel->addFieldToFilter("\162\157\x6c\145\x5f\x74\171\160\145", "\x47");
        return $G443E->toOptionArray();
    }
    private function deleteRoleMethodsConfig(string $o0YTW)
    {
        $lSulb = $this->twofautility->ifSandboxTrialEnabled() ? "\156\x75\x6d\142\145\162\137\157\146\137\141\x63\x74\x69\x76\145\x4d\145\164\150\157\144\x5f" . $o0YTW . "\137" . $this->currentAdminUser : "\x6e\x75\155\142\x65\x72\137\x6f\146\x5f\141\x63\164\x69\x76\145\x4d\145\x74\x68\x6f\x64\x5f" . $o0YTW;
        $zfIMx = $this->twofautility->ifSandboxTrialEnabled() ? "\x61\x64\x6d\151\156\x5f\x61\143\x74\151\x76\x65\x4d\x65\164\x68\x6f\144\163\x5f" . $o0YTW . "\137" . $this->currentAdminUser : "\x61\144\155\x69\156\x5f\141\x63\x74\151\x76\145\x4d\145\164\x68\157\144\163\137" . $o0YTW;
        $this->twofautility->setStoreConfig($lSulb, NULL);
        $this->twofautility->setStoreConfig($zfIMx, NULL);
    }
    private function applyRulesToRoles(array $W8E0X)
    {
        $y_m43 = $this->getAllAdminRoles();
        foreach ($W8E0X as $Sii_T) {
            if (!isset($Sii_T["\x72\157\x6c\145"], $Sii_T["\x6d\145\x74\x68\157\x64\x73"])) {
                goto nHeFl;
            }
            $kh6W2 = $Sii_T["\x72\157\x6c\x65"] ?? '';
            $q2e53 = array_map(fn($x7qFE) => is_array($x7qFE) ? trim($x7qFE["\x6d\145\x74\x68\x6f\144"]) : trim($x7qFE), $Sii_T["\155\x65\164\x68\x6f\x64\163"] ?? []);
            if ($kh6W2 === "\x41\x6c\x6c\x20\x52\x6f\154\x65\163") {
                goto UUZkX;
            }
            $this->saveMethodsConfig($kh6W2, $q2e53);
            goto rrL6H;
            UUZkX:
            foreach ($y_m43 as $o0YTW) {
                $o0YTW = $o0YTW["\x6c\x61\x62\x65\154"];
                $this->saveMethodsConfig($o0YTW, $q2e53);
                UETPv:
            }
            EDCO1:
            rrL6H:
            nHeFl:
            vD_P4:
        }
        uNBBP:
    }
    private function saveMethodsConfig(string $o0YTW, array $q2e53)
    {
        $lSulb = $this->twofautility->ifSandboxTrialEnabled() ? "\156\x75\x6d\142\145\162\137\157\146\x5f\141\x63\x74\x69\x76\x65\115\x65\164\150\x6f\144\137" . $o0YTW . "\137" . $this->currentAdminUser : "\x6e\165\x6d\x62\145\x72\137\157\x66\x5f\141\143\164\x69\x76\x65\x4d\145\x74\150\x6f\x64\x5f" . $o0YTW;
        $zfIMx = $this->twofautility->ifSandboxTrialEnabled() ? "\x61\144\x6d\151\x6e\137\141\x63\x74\x69\x76\x65\115\x65\164\x68\157\x64\163\x5f" . $o0YTW . "\137" . $this->currentAdminUser : "\141\144\155\x69\x6e\x5f\x61\143\164\x69\166\x65\115\145\164\150\157\144\163\x5f" . $o0YTW;
        $this->twofautility->setStoreConfig($lSulb, count($q2e53));
        $this->twofautility->setStoreConfig($zfIMx, json_encode($q2e53));
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_ADMIN_2FA);
    }
}