<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Tfaadmincustomerbox;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
class Index extends BaseAdminAction implements HttpPostActionInterface, HttpGetActionInterface
{
    private $adminRoleModel;
    private $currentAdminUser;
    public function __construct(Context $Wryla, TwoFAUtility $xxknW, PageFactory $RV_Yo, \Magento\Framework\Message\ManagerInterface $qIIOv, \Psr\Log\LoggerInterface $DzkvE, \Magento\Authorization\Model\ResourceModel\Role\Collection $yUrrP)
    {
        parent::__construct($Wryla, $RV_Yo, $xxknW, $qIIOv, $DzkvE);
        $this->adminRoleModel = $yUrrP;
    }
    public function execute()
    {
        try {
            $kZYL8 = $this->getRequest()->getParams();
            $this->currentAdminUser = $this->twofautility->getCurrentAdminUser()->getUsername();
            if (!$this->isFormOptionBeingSaved($kZYL8)) {
                goto Qwqw8;
            }
            $this->processSignInSettings($kZYL8);
            $this->messageManager->addSuccessMessage(TwoFAMessages::SETTINGS_SAVED);
            Qwqw8:
        } catch (Exception $rCfaz) {
            $this->messageManager->addErrorMessage(__("\x41\x6e\40\145\162\x72\x6f\x72\x20\157\x63\x63\x75\162\162\x65\144\72\x20\45\61", $rCfaz->getMessage()));
            $this->logger->debug($rCfaz->getMessage());
        }
        $C6HBf = $this->resultPageFactory->create();
        $C6HBf->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $C6HBf;
    }
    private function processSignInSettings(array $kZYL8)
    {
        $LUYGs = $this->twofautility->isCustomerRegistered();
        if ($LUYGs) {
            goto JOWPO;
        }
        $this->messageManager->addErrorMessage(TwoFAMessages::NOT_REGISTERED);
        $V9Ual = $this->resultRedirectFactory->create();
        $V9Ual->setPath("\x6d\x6f\164\x77\x6f\146\x61\x2f\x61\x63\x63\157\165\x6e\x74\57\x69\x6e\144\145\170");
        return $V9Ual;
        JOWPO:
        if (!(isset($kZYL8["\157\160\x74\151\157\x6e"]) && $kZYL8["\157\x70\164\151\157\x6e"] === "\x73\x61\x76\145\x53\151\x67\x6e\111\156\x53\145\164\x74\151\156\147\163\137\141\x64\x6d\x69\x6e")) {
            goto wkyUi;
        }
        if (!isset($kZYL8["\162\x75\x6c\145\x73"])) {
            goto bGfqs;
        }
        $jWhr5 = json_decode($kZYL8["\x72\x75\x6c\x65\x73"], true);
        if (!(json_last_error() !== JSON_ERROR_NONE)) {
            goto bhvlB;
        }
        throw new Exception(__("\111\156\x76\141\x6c\x69\x64\40\x4a\123\x4f\x4e\40\151\156\x20\162\165\x6c\x65\163\40\160\141\162\x61\x6d\x65\164\x65\x72"));
        bhvlB:
        $this->twofautility->setStoreConfig(TwoFAConstants::CURRENT_ADMIN_RULE, json_encode($jWhr5));
        if (isset($kZYL8["\x64\145\x6c\145\x74\145\137\162\x6f\154\x65"])) {
            goto wQIla;
        }
        $this->applyRulesToRoles($jWhr5);
        goto j4AQX;
        wQIla:
        $this->processRoleDeletion($kZYL8);
        j4AQX:
        bGfqs:
        wkyUi:
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
    }
    private function processRoleDeletion(array $kZYL8)
    {
        $IYOvn = $kZYL8["\144\x65\x6c\x65\x74\145\137\x72\157\x6c\145"];
        if ($IYOvn === "\101\154\154\40\122\x6f\154\145\163") {
            goto M8xuo;
        }
        $this->deleteRoleMethodsConfig($IYOvn);
        goto m1mVf;
        M8xuo:
        $hq_51 = $this->getAllAdminRoles();
        foreach ($hq_51 as $GaA15) {
            $GaA15 = $GaA15["\154\141\x62\145\154"];
            $this->deleteRoleMethodsConfig($GaA15);
            urDy2:
        }
        VmHEN:
        m1mVf:
    }
    private function getAllAdminRoles() : array
    {
        $iCpZM = $this->adminRoleModel->addFieldToFilter("\162\157\x6c\145\137\x74\x79\x70\x65", "\107");
        return $iCpZM->toOptionArray();
    }
    private function deleteRoleMethodsConfig(string $GaA15)
    {
        $C2DDd = $this->twofautility->ifSandboxTrialEnabled() ? "\x6e\165\x6d\142\x65\x72\x5f\x6f\x66\137\x61\x63\164\x69\x76\x65\x4d\145\164\x68\157\144\137" . $GaA15 . "\x5f" . $this->currentAdminUser : "\x6e\x75\x6d\x62\x65\x72\137\x6f\146\137\x61\x63\164\151\166\145\x4d\145\x74\150\157\144\137" . $GaA15;
        $YYpE4 = $this->twofautility->ifSandboxTrialEnabled() ? "\141\x64\x6d\151\156\137\141\x63\164\x69\x76\145\x4d\145\x74\x68\x6f\x64\163\x5f" . $GaA15 . "\137" . $this->currentAdminUser : "\141\144\x6d\x69\x6e\137\x61\143\x74\x69\166\x65\x4d\145\x74\150\157\144\x73\x5f" . $GaA15;
        $this->twofautility->setStoreConfig($C2DDd, NULL);
        $this->twofautility->setStoreConfig($YYpE4, NULL);
    }
    private function applyRulesToRoles(array $jWhr5)
    {
        $hq_51 = $this->getAllAdminRoles();
        foreach ($jWhr5 as $JAZHP) {
            if (!isset($JAZHP["\162\157\x6c\x65"], $JAZHP["\155\145\164\150\157\144\x73"])) {
                goto rQcR1;
            }
            $bv6pz = $JAZHP["\x72\157\154\145"] ?? '';
            $qNzZE = array_map(fn($LsA4k) => is_array($LsA4k) ? trim($LsA4k["\x6d\145\x74\x68\x6f\144"]) : trim($LsA4k), $JAZHP["\x6d\145\164\150\x6f\x64\163"] ?? []);
            if ($bv6pz === "\101\x6c\x6c\40\x52\x6f\x6c\145\163") {
                goto PRD9k;
            }
            $this->saveMethodsConfig($bv6pz, $qNzZE);
            goto Hq7WD;
            PRD9k:
            foreach ($hq_51 as $GaA15) {
                $GaA15 = $GaA15["\x6c\x61\142\145\x6c"];
                $this->saveMethodsConfig($GaA15, $qNzZE);
                grd_5:
            }
            d1Ftc:
            Hq7WD:
            rQcR1:
            NpQ7t:
        }
        kknor:
    }
    private function saveMethodsConfig(string $GaA15, array $qNzZE)
    {
        $C2DDd = $this->twofautility->ifSandboxTrialEnabled() ? "\156\x75\155\x62\x65\162\137\157\x66\x5f\141\143\164\x69\x76\145\x4d\x65\164\x68\x6f\x64\x5f" . $GaA15 . "\x5f" . $this->currentAdminUser : "\156\165\155\x62\x65\x72\137\157\x66\137\141\143\x74\151\x76\145\115\x65\x74\150\x6f\144\137" . $GaA15;
        $YYpE4 = $this->twofautility->ifSandboxTrialEnabled() ? "\x61\x64\155\151\x6e\137\x61\143\164\x69\166\145\115\x65\x74\x68\x6f\144\x73\137" . $GaA15 . "\x5f" . $this->currentAdminUser : "\x61\x64\x6d\x69\x6e\x5f\x61\x63\x74\151\x76\145\115\145\164\x68\x6f\x64\x73\137" . $GaA15;
        $this->twofautility->setStoreConfig($C2DDd, count($qNzZE));
        $this->twofautility->setStoreConfig($YYpE4, json_encode($qNzZE));
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_2FA_ADMIN_CUSTOMER_BOX);
    }
}