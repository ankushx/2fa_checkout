<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Tfasettingsconfigurationtable;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Api\WebsiteRepositoryInterface;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
class Index extends BaseAdminAction implements HttpPostActionInterface, HttpGetActionInterface
{
    private $adminRoleModel;
    private $websiteRepository;
    private $groupRepository;
    private $searchCriteriaBuilder;
    private $currentAdminUser;
    public function __construct(Context $o7ri0, TwoFAUtility $w_75l, PageFactory $nVdQu, \Magento\Framework\Message\ManagerInterface $cSCD3, \Psr\Log\LoggerInterface $Er3M6, \Magento\Authorization\Model\ResourceModel\Role\Collection $nvKpK, WebsiteRepositoryInterface $ObCIa, GroupRepositoryInterface $GUgkQ, SearchCriteriaBuilder $UWT9p)
    {
        parent::__construct($o7ri0, $nVdQu, $w_75l, $cSCD3, $Er3M6);
        $this->adminRoleModel = $nvKpK;
        $this->websiteRepository = $ObCIa;
        $this->groupRepository = $GUgkQ;
        $this->searchCriteriaBuilder = $UWT9p;
    }
    public function execute()
    {
        $this->currentAdminUser = $this->twofautility->getCurrentAdminUser()->getUsername();
        try {
            $Es7BT = $this->getRequest()->getParams();
            if (!$this->isFormOptionBeingSaved($Es7BT)) {
                goto VumY3;
            }
            $this->processSignInSettings($Es7BT);
            $this->messageManager->addSuccessMessage(TwoFAMessages::SETTINGS_SAVED);
            VumY3:
        } catch (Exception $RzI4x) {
            $this->messageManager->addErrorMessage(__("\101\156\x20\145\x72\x72\x6f\162\x20\x6f\x63\x63\x75\162\x72\145\x64\72\x20\45\x31", $RzI4x->getMessage()));
            $this->logger->debug($RzI4x->getMessage());
        }
        $mPte4 = $this->resultPageFactory->create();
        $mPte4->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $mPte4;
    }
    private function processSignInSettings(array $Es7BT)
    {
        if (isset($Es7BT["\144\145\154\x65\164\x65\137\162\157\x6c\145\137\141\x64\x6d\x69\x6e"])) {
            goto yiQai;
        }
        if (!isset($Es7BT["\x64\145\154\145\164\145\137\162\157\154\x65\137\x63\x75\x73\164\x6f\x6d\145\162"])) {
            goto wqWaD;
        }
        if (!isset($Es7BT["\x72\x75\154\x65\163"])) {
            goto kSrWf;
        }
        $FvTsY = json_decode($Es7BT["\162\165\154\145\163"], true);
        foreach ($FvTsY as &$v9eIl) {
            $v9eIl["\x73\151\164\145"] = preg_replace("\x2f\x5c\156\57", '', trim($v9eIl["\x73\151\164\145"]));
            $v9eIl["\147\x72\x6f\x75\x70"] = preg_replace("\x2f\134\x6e\57", '', trim($v9eIl["\x67\x72\x6f\x75\x70"]));
            lTPSs:
        }
        Br47T:
        unset($v9eIl);
        $this->twofautility->setStoreConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE, json_encode($FvTsY));
        $mYY4b = $this->getAllCustomerGroups();
        if (!(isset($Es7BT["\144\x65\x6c\x65\x74\145\137\162\x6f\154\145\x5f\x73\151\x74\145"]) && isset($Es7BT["\144\145\x6c\x65\164\x65\x5f\x72\x6f\154\145"]))) {
            goto USEL4;
        }
        $this->processRoleDeletion_customer($Es7BT, $mYY4b);
        USEL4:
        kSrWf:
        wqWaD:
        goto CwSrt;
        yiQai:
        if (!isset($Es7BT["\x72\165\154\145\x73"])) {
            goto Y3sKZ;
        }
        $FvTsY = json_decode($Es7BT["\x72\x75\154\145\x73"], true);
        if (!(json_last_error() !== JSON_ERROR_NONE)) {
            goto i_fDe;
        }
        throw new Exception(__("\111\156\x76\141\154\x69\144\40\x4a\x53\x4f\116\40\151\156\x20\162\x75\x6c\145\163\x20\x70\141\162\x61\155\x65\x74\145\x72"));
        i_fDe:
        $this->twofautility->setStoreConfig(TwoFAConstants::CURRENT_ADMIN_RULE, json_encode($FvTsY));
        $this->processRoleDeletion_For_Admin($Es7BT);
        Y3sKZ:
        CwSrt:
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
    }
    private function processRoleDeletion_For_Admin(array $Es7BT)
    {
        $hz56M = $Es7BT["\144\145\154\145\164\x65\x5f\x72\157\x6c\145\x5f\x61\144\155\151\x6e"];
        if ($hz56M === "\x41\x6c\154\40\x52\x6f\154\145\x73") {
            goto JoTyo;
        }
        $this->deleteRoleMethodsConfig_admin($hz56M);
        goto F8ik1;
        JoTyo:
        $JckaD = $this->getAllAdminRoles();
        foreach ($JckaD as $VuvCi) {
            $VuvCi = $VuvCi["\x6c\x61\x62\x65\x6c"];
            $this->deleteRoleMethodsConfig_admin($VuvCi);
            MJPLN:
        }
        R2ZFe:
        F8ik1:
    }
    private function getAllAdminRoles() : array
    {
        $xSn8u = $this->adminRoleModel->addFieldToFilter("\x72\157\x6c\145\x5f\164\171\160\x65", "\107");
        return $xSn8u->toOptionArray();
    }
    private function deleteRoleMethodsConfig_admin(string $VuvCi)
    {
        $fZyX9 = $this->twofautility->ifSandboxTrialEnabled() ? "\156\x75\x6d\x62\145\162\x5f\157\146\x5f\x61\x63\x74\x69\x76\145\x4d\x65\x74\150\x6f\x64\137" . $VuvCi . "\137" . $this->currentAdminUser : "\x6e\x75\x6d\142\145\162\137\157\x66\x5f\x61\143\164\151\x76\x65\x4d\145\164\150\x6f\x64\x5f" . $VuvCi;
        $FeZRS = $this->twofautility->ifSandboxTrialEnabled() ? "\141\x64\155\151\156\137\x61\143\x74\151\x76\x65\x4d\145\x74\150\x6f\144\x73\137" . $VuvCi . "\137" . $this->currentAdminUser : "\141\x64\155\x69\156\137\x61\x63\x74\151\166\x65\x4d\x65\x74\x68\x6f\144\x73\x5f" . $VuvCi;
        $this->twofautility->setStoreConfig($fZyX9, NULL);
        $this->twofautility->setStoreConfig($FeZRS, NULL);
    }
    private function getAllCustomerGroups()
    {
        $jV1kq = $this->searchCriteriaBuilder->create();
        $dW5cQ = $this->groupRepository->getList($jV1kq);
        $eIfhY = [];
        foreach ($dW5cQ->getItems() as $fHgHf) {
            $eIfhY[$fHgHf->getId()] = $fHgHf->getCode();
            fufsF:
        }
        rpeT8:
        return $eIfhY;
    }
    private function processRoleDeletion_customer(array $Es7BT, array $mYY4b)
    {
        $RTi59 = $Es7BT["\144\145\154\x65\164\145\x5f\162\157\x6c\145"];
        $ainLW = $Es7BT["\144\145\x6c\x65\164\x65\137\x72\x6f\x6c\x65\137\163\151\x74\145"];
        if ($ainLW === "\x41\154\x6c\x20\123\x69\164\145\x73" && $RTi59 === "\101\x6c\154\40\x47\162\x6f\165\160\163") {
            goto lN7lH;
        }
        if ($RTi59 === "\101\x6c\x6c\x20\x47\x72\x6f\x75\160\163") {
            goto AU5E7;
        }
        if ($ainLW === "\101\x6c\154\40\x53\x69\x74\145\163") {
            goto MUgJn;
        }
        $YTBS0 = $this->twofautility->getWebsiteByCodeOrName($ainLW);
        if (!$YTBS0) {
            goto xtCHJ;
        }
        $xpQhV = $YTBS0->getId();
        $this->deleteRoleMethodsConfig($xpQhV, $RTi59);
        xtCHJ:
        goto WeXw8;
        lN7lH:
        foreach ($this->getAllWebsites() as $gDw1s) {
            $YTBS0 = $this->twofautility->getWebsiteByCodeOrName($gDw1s);
            if (!isset($YTBS0)) {
                goto u1j5G;
            }
            $xpQhV = $YTBS0->getId();
            foreach ($mYY4b as $ZEjpl => $hB54f) {
                $this->deleteRoleMethodsConfig($xpQhV, $hB54f);
                llccU:
            }
            dUMSy:
            u1j5G:
            BzBK8:
        }
        aFxIf:
        goto WeXw8;
        AU5E7:
        $YTBS0 = $this->twofautility->getWebsiteByCodeOrName($ainLW);
        if (!isset($YTBS0)) {
            goto GpK24;
        }
        $xpQhV = $YTBS0->getId();
        foreach ($mYY4b as $ZEjpl => $hB54f) {
            $this->deleteRoleMethodsConfig($xpQhV, $hB54f);
            uJLdB:
        }
        RNQFo:
        GpK24:
        goto WeXw8;
        MUgJn:
        foreach ($this->getAllWebsites() as $gDw1s) {
            $YTBS0 = $this->twofautility->getWebsiteByCodeOrName($gDw1s);
            if (!isset($YTBS0)) {
                goto oHhSl;
            }
            $xpQhV = $YTBS0->getId();
            $this->deleteRoleMethodsConfig($xpQhV, $RTi59);
            oHhSl:
            KOcmm:
        }
        wlxW5:
        WeXw8:
    }
    private function getAllWebsites()
    {
        $cfB3v = $this->websiteRepository->getList();
        return array_map(function ($YTBS0) {
            return $YTBS0->getCode();
        }, $cfB3v);
    }
    private function deleteRoleMethodsConfig(string $SFJZx, string $fHgHf)
    {
        $this->twofautility->setStoreConfig("\156\x75\155\x62\x65\162\137\157\146\x5f\x61\x63\164\151\x76\145\115\145\x74\x68\157\x64\x5f\x63\165\163\164\157\x6d\x65\162\x5f" . $fHgHf . $SFJZx, NULL);
        $this->twofautility->setStoreConfig("\141\143\x74\x69\166\x65\115\145\x74\150\x6f\x64\x73\x5f" . $fHgHf . $SFJZx, NULL);
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_TFA_SETTINGS_CONFIGURATION_TABLE);
    }
    private function applyRulesToRoles(array $FvTsY)
    {
        $JckaD = $this->getAllAdminRoles();
        foreach ($FvTsY as $v9eIl) {
            if (!isset($v9eIl["\x72\x6f\x6c\145"], $v9eIl["\x6d\145\x74\x68\x6f\144\x73"])) {
                goto YR7Yp;
            }
            $VNbuY = $v9eIl["\162\157\x6c\x65"] ?? '';
            $MGqu0 = array_map(fn($PTS9C) => is_array($PTS9C) ? trim($PTS9C["\155\x65\x74\150\x6f\x64"]) : trim($PTS9C), $v9eIl["\155\145\164\x68\x6f\x64\163"] ?? []);
            if ($VNbuY === "\x41\x6c\154\40\x52\x6f\x6c\145\163") {
                goto Xgk1d;
            }
            $this->saveMethodsConfig($VNbuY, $MGqu0);
            goto OKMCL;
            Xgk1d:
            foreach ($JckaD as $VuvCi) {
                $VuvCi = $VuvCi["\154\x61\142\x65\154"];
                $this->saveMethodsConfig($VuvCi, $MGqu0);
                rCZOt:
            }
            MMZSf:
            OKMCL:
            YR7Yp:
            J5bJ6:
        }
        PdSgX:
    }
    private function saveMethodsConfig(string $VuvCi, array $MGqu0)
    {
        $fZyX9 = $this->twofautility->ifSandboxTrialEnabled() ? "\156\x75\155\142\145\162\x5f\157\x66\x5f\141\143\164\x69\x76\x65\115\x65\164\150\157\x64\137" . $VuvCi . "\137" . $this->currentAdminUser : "\156\x75\155\142\x65\x72\x5f\157\146\x5f\x61\143\164\151\x76\x65\x4d\145\164\x68\157\x64\137" . $VuvCi;
        $FeZRS = $this->twofautility->ifSandboxTrialEnabled() ? "\x61\144\x6d\151\x6e\137\x61\x63\x74\x69\x76\145\x4d\145\x74\150\157\x64\x73\x5f" . $VuvCi . "\137" . $this->currentAdminUser : "\x61\144\155\151\156\x5f\141\143\164\x69\x76\145\x4d\x65\164\150\x6f\144\x73\x5f" . $VuvCi;
        $this->twofautility->setStoreConfig($fZyX9, count($MGqu0));
        $this->twofautility->setStoreConfig($FeZRS, json_encode($MGqu0));
    }
}