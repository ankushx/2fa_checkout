<?php

namespace MiniOrange\TwoFA\Plugin\Adminhtml\Block\System\Account\Edit;

use Closure;
use Google\Authenticator\GoogleAuthenticator;
use Magento\Backend\Model\Auth\Session;
use Magento\Config\Model\Config\Source\Enabledisable;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutInterface;
use Magento\User\Model\User;
use Magento\User\Model\UserFactory;
use MiniOrange\TwoFA\Block\Adminhtml\User\Edit\Tab\Renderer\DisableButton;
use MiniOrange\TwoFA\Block\Adminhtml\User\Edit\Tab\Renderer\QrCode;
use MiniOrange\TwoFA\Block\Adminhtml\User\Edit\Tab\Renderer\TrustedDevices;
class Form
{
    protected $_enableDisable;
    protected $_coreRegistry;
    protected $_layout;
    protected $_authSession;
    protected $_userFactory;
    protected $_helperData;
    public function __construct(Enabledisable $FQ7c9, Registry $FLcaU, LayoutInterface $Xg3zF, Session $DuRJB, UserFactory $EwP5N)
    {
        $this->_enableDisable = $FQ7c9;
        $this->_coreRegistry = $FLcaU;
        $this->_layout = $Xg3zF;
        $this->_authSession = $DuRJB;
        $this->_userFactory = $EwP5N;
    }
    public function aroundGetFormHtml(\Magento\Backend\Block\System\Account\Edit\Form $xPljD, Closure $P8A1Q)
    {
        $form = $xPljD->getForm();
        $ysEYG = $this->_authSession->getUser()->getId();
        $user = $this->_userFactory->create()->load($ysEYG);
        $user->unsetData("\x70\141\x73\163\167\x6f\162\144");
        $this->_coreRegistry->register("\155\x70\137\x70\145\162\x6d\151\163\x73\151\x6f\156\163\137\165\x73\145\x72", $user);
        $l_4IK = "\127\x45\107\x41\102\x48\115\117\101\101\127\x4d\x57\x46\x4b\130";
        if (!0) {
            goto RfoIj;
        }
        $pOLcU = $form->addFieldset("\155\160\137\x74\x66\141\137\163\x65\x63\165\162\x69\164\171", ["\x6c\x65\147\145\156\x64" => __("\x53\145\143\165\162\151\164\171")]);
        $pOLcU->addField("\155\x70\137\164\146\141\x5f\x65\156\x61\142\154\x65", "\x73\x65\x6c\x65\143\x74", ["\156\141\x6d\145" => "\155\x70\137\164\x66\x61\x5f\x65\x6e\141\x62\x6c\x65", "\x6c\141\x62\145\x6c" => __("\124\x77\157\x2d\x46\141\x63\x74\x6f\x72\40\x41\165\x74\x68\x65\156\164\x69\x63\x61\164\x69\x6f\156"), "\x74\x69\164\154\145" => __("\x54\167\x6f\x2d\x46\x61\x63\164\157\x72\x20\x41\x75\164\x68\x65\x6e\x74\151\143\141\164\151\157\x6e"), "\166\141\x6c\x75\145\163" => $this->_enableDisable->toOptionArray(), "\x61\146\164\145\x72\137\x68\164\x6d\x6c" => "\102\162\151\x61\x6e\x20\164\162\x61\156"]);
        if (!$user->getData("\155\160\x5f\x74\x66\x61\x5f\x65\156\x61\x62\154\145")) {
            goto N47Rz;
        }
        $hIOi2 = $pOLcU->addFieldset("\x6d\160\x5f\164\x66\141\x5f\x74\162\x75\163\164\137\x64\145\166\151\x63\x65", ["\154\145\147\x65\156\x64" => __("\124\x72\x75\x73\164\x65\x64\x20\x44\145\166\x69\x63\x65\x73")]);
        $hIOi2->addField("\x6d\160\137\164\x66\x61\137\164\162\165\x73\164\145\144\137\144\145\166\151\x63\145", "\x6c\x61\x62\x65\x6c", ["\156\141\x6d\x65" => "\155\160\x5f\164\x66\x61\137\164\x72\x75\x73\164\x65\x64\137\x64\x65\166\151\x63\145"])->setAfterElementHtml($this->getTrustedDeviceHtml($user));
        N47Rz:
        $ncl0K = $user->getData();
        $ncl0K["\x6d\160\x5f\x74\146\141\x5f\163\145\x63\162\145\x74\x5f\x74\x65\x6d\x70"] = $ncl0K["\x6d\160\x5f\164\x66\141\x5f\163\x65\x63\x72\x65\x74\137\164\145\155\160\x5f\x68\151\x64\x64\145\x6e"] = $l_4IK;
        $ncl0K["\155\160\x5f\164\x66\x61\137\163\164\x61\x74\165\163"] = $user->getMpTfaStatus();
        $form->setValues($ncl0K);
        $xPljD->setForm($form);
        RfoIj:
        return $P8A1Q();
    }
    public function getTrustedDeviceHtml($ot3Zk)
    {
        return $this->_layout->createBlock(TrustedDevices::class)->setUserObject($ot3Zk)->toHtml();
    }
}