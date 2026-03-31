<?php
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;
define('DS', DIRECTORY_SEPARATOR);
require_once __DIR__.DS.'helpers'.DS.'DbHelper.php';
require_once JPATH_ADMINISTRATOR . '/components/com_users/helpers/users.php';

$app = Factory::getApplication();
$twofactor = \UsersHelper::getTwoFactorMethods();

//https://stg-aadtest.iit.local/?morequest=oauthredirect&app_name=azure

$dbHlpr = new DbHelper();
$params = $dbHlpr->getThemeConfig();

?>
<!DOCTYPE HTML>

<html lang="<?= $this->language ?>" dir="<?= $this->direction ?>">
    <head>
        <meta charset="<?= $this->getCharset() ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <jdoc:include type="head" />
    </head>
    <body class="uk-flex uk-flex-middle" uk-height-viewport>
        <div class="tm-offline uk-container uk-container-small uk-text-center">

            <!--<jdoc:include type="message" />-->

            <?php if ($app->get('offline_image', '')) : ?>
                <?= HTMLHelper::_('image', $app->get('offline_image'), htmlspecialchars($app->get('sitename'), ENT_COMPAT, 'UTF-8'), [], false, 0) ?>
            <?php endif ?>

            <h1><?= htmlspecialchars($app->get('sitename'), ENT_COMPAT, 'UTF-8') ?></h1>

            <?php if ($app->get('display_offline_message', 1) == 1 && str_replace(' ', '', $app->get('offline_message')) != '') : ?>

                <!--<p><?= $app->get('offline_message'); ?></p>-->

            <?php elseif ($app->get('display_offline_message', 1) == 2) : ?>

                <p><?= Text::_('JOFFLINE_MESSAGE') ?></p>

            <?php endif ?>
			
			<?php 
                        if($params->azure_login=="true"){
			$uri = \Joomla\CMS\Uri\Uri::getInstance(); ?>
			
			<div class="uk-flex-middle uk-grid-small uk-child-width-auto uk-flex-center uk-grid" uk-grid="">    
    
                <div class="el-item uk-first-column">
					<div class="el-item">
						<a class="el-content uk-button uk-button-secondary uk-button-small" title="Login" href="<?php echo $uri->base(); ?>?morequest=oauthredirect&amp;app_name=<?php echo $params->azure_app_name ?>">
								Login   
						</a>
					</div>
				</div>
                        <?php }// END IF
                        else {
                        ?>
             
		<form class="uk-panel uk-margin" action="<?= Route::_('index.php', true) ?>" method="post">

                <div class="uk-margin">
                    <input class="uk-input" type="text" name="username" placeholder="<?= Text::_('JGLOBAL_USERNAME') ?>">
                </div>

                <div class="uk-margin">
                    <input class="uk-input" type="password" name="password" placeholder="<?= Text::_('JGLOBAL_PASSWORD') ?>">
                </div>

                <?php if (count($twofactor) > 1) : ?>
                    <div class="uk-margin">
                        <input class="uk-input" type="text" name="secretkey" tabindex="0" size="18" placeholder="<?= Text::_('JGLOBAL_SECRETKEY') ?>" />
                    </div>
                <?php endif ?>

                <div class="uk-margin">
                    <button class="uk-button uk-button-primary uk-width-1-1" type="submit" name="Submit"><?= Text::_('JLOGIN') ?></button>
                </div>

                <div class="uk-margin">
                    <label>
                        <input type="checkbox" name="remember" value="yes" placeholder="<?= Text::_('JGLOBAL_REMEMBER_ME') ?>">
                        <?= Text::_('JGLOBAL_REMEMBER_ME') ?>
                    </label>
                </div>

                <input type="hidden" name="option" value="com_users">
                <input type="hidden" name="task" value="user.login">
                <input type="hidden" name="return" value="<?= base64_encode(Uri::base()) ?>">
                <?= HTMLHelper::_('form.token') ?>

            </form>
<?php } ?>
        </div>

    </body>
</html>
