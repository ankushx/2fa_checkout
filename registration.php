<?php
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'MiniOrange_TwoFA',
    __DIR__ . '/TwoFA'
);

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'MiniOrange_TwoFAHyvaUI',
    __DIR__ . '/TwoFAHyvaUI'
);