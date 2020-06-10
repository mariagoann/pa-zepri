<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php 
                    if(Yii::$app->session->has('fullname')){
                        echo Yii::$app->session->get('fullname');
                    }
                ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Karyawan',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Daftar Karyawan',
                                'icon' => 'circle-o',
                                'url' => ['/personalinfo'],
                            ],
                            [
                                'label' => 'Organisasi',
                                'icon' => 'circle-o',
                                'url' => ['/organization'],
                            ],
                            [
                                'label' => 'Job Position',
                                'icon' => 'circle-o',
                                'url' => ['/jobposition'],
                            ],
                            [
                                'label' => 'Job Title',
                                'icon' => 'circle-o',
                                'url' => ['/jobtitle'],
                            ],
                            [
                                'label' => 'Job Level',
                                'icon' => 'circle-o',
                                'url' => ['/joblevel'],
                            ],
                            [
                                'label' => 'Squad',
                                'icon' => 'circle-o',
                                'url' => ['/squad'],
                            ],
                        ],
                        'visible' => !Yii::$app->user->isGuest
                    ],
                    [
                        'label' => 'Performance Appraisal',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Hasil Penilaian',
                                'icon' => 'circle-o',
                                'url' => ['#'],
                            ],
                            [
                                'label' => 'Penilaian Kinerja',
                                'icon' => 'circle-o',
                                'url' => ['#'],
                            ],
                        ],
                        'visible' => !Yii::$app->user->isGuest
                    ],
                    [
                        'label' => 'Karyawan Penilai',
                        'icon' => 'share',
                        'url' => ['/periode'],
                        'visible' => !Yii::$app->user->isGuest
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
