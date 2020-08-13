<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
$_roleName = [
    'head'=>'Head Team People and Culture',
    'admin'=>'Admin',
    'user'=>'Staff'
];
$message = null;
$badge = null;
if(Yii::$app->session->has('message')){
    $message = json_decode(Yii::$app->session->get('message'),true);
    if(!empty($message)){
        $badge = $message['badge'];
        $message = $message['notif'];
    }
}
$url = Url::to(['api/read']);
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">PT PROPERTY</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id='notif'>
                        <i class="fa fa-bell-o"></i>
                        <?php
                            if($badge!=null && $badge!=0){
                                echo "<span class='label label-danger'>".$badge."</span>";
                            }else{
                                echo "<span class='label label-danger'></span>";
                            }
                        ?>
                    </a>

                    <?php
                        if($message!=null){
                    ?>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?php echo $badge;?> messages</li>
                    <?php
                        foreach ($message as $key => $value) {
                    ?>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                                 alt="User Image"/>
                                        </div>
                                        <h4>
                                            System
                                            <small><i class="fa fa-clock-o"></i><?php echo $value['Created_at'];?></small>
                                        </h4>
                                        <small><?php echo $value['Message'];?></small>
                                    </a>
                                </li>
                                <!-- end message -->
                            </ul>
                        </li>
                    <?php
                        }
                    ?>

                    </ul>
                    <?php
                        }
                    ?>
                </li>
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">
                        <?php 
                            if(Yii::$app->session->has('fullname')){
                                echo Yii::$app->session->get('fullname');
                            }
                        ?>
                    </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?php 
                                    if(Yii::$app->session->has('fullname')){
                                        echo Yii::$app->session->get('fullname');
                                    }
                                    if(Yii::$app->session->has('role')){
                                        $role = $_roleName[Yii::$app->session->get('role')];
                                        echo "<br>";
                                        echo "<span>".$role."</span>";
                                    }
                                ?>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                            <?= Html::a(
                                    'Profile',
                                    ['/personalinfo/update','id'=>Yii::$app->session->has('personalid')==false?0:Yii::$app->session->get('personalid'),'type'=>'self'],
                                    ['class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div> 
                             <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<?php
$script = <<< JS
document.getElementById("notif").onclick = function(){
    // console.log("$url");
    $.ajax({
        type: "GET",
        url: "$url",
        success: function(response){
            console.log(response);
        },
        error: function(){
            console.log('Something went wrong!');
        }
    });
};
JS;
$this->registerJs($script);
?>
