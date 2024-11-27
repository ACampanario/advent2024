<?php
// Configurar la localización en bootstrap.php
use Cake\I18n\I18n;

I18n::setLocale('en_US');

// Traducir cadenas en vistas/controladores
use Cake\I18n\__;

$count = 1;
echo __n('One file removed', '{0} files removed', $count, $count);

?>
    <br/>
<?php

$count = 10;
echo __n('One file removed', '{0} files removed', $count, $count);

?>
    <br/>
<?php

$messageCount = 1;

// Pluralización automática
echo __n('1 new message', '{0} new messages', $messageCount, $messageCount);

?>
    <br/>
<?php

$messageCount = 3;

// Pluralización automática
echo __n('1 new message', '{0} new messages', $messageCount, $messageCount);

?>
    <br/>
<?php
