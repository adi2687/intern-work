<header>
    <div class="h-2">. </div>
    <div class="d-flex justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-light blur-background main-navbar py-2"
    style="width:80vw; background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border-radius: 50px;">
            
    <a class="flex flex-row" href="<?= route("/"); ?>" style="align-items: center; text-decoration: none;">
                 <img src="<?php assets('img/eSubhalekha.png') ?>" alt="logo" style="width: 40px; height: 40px; margin-right: 8px;" />
                <span style="margin: 0;" class="nav-name">eSubhalekha</span>
            </a>

            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse me-auto navbar-collapse nav-tabs" style="border : 0px;" id="navbarSupportedContent">

                <?php if (url() != route('login')) { ?>

                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link font-heading nav-comp" aria-current="page" href="<?= route("/"); ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-heading nav-comp" aria-current="page" href="#pricings">Price</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-heading nav-comp" aria-current="page" href="<?php echo route("themes"); ?>">Themes</a>
                        </li>

                        <?php if (App::getSession()) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link font-heading dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle" style="font-size: initial;"></i>
                                    <?php echo App::getUser()['name']; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="<?php echo route('dashboard'); ?>">Dashboard</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" aria-current="page" href="<?php echo route('logout'); ?>">Logout</a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <li class="nav-item">
                            <?php if (!App::getSession()) { ?>
                                <a class="nav-link font-heading btn btn-secondary rounded-pill" style="margin-left:-20px" aria-current="page"
                                    href="<?php echo route('register') . "?back=" . url(); ?>">Login/Signup</a>
                            <?php } ?>
                        </li>
                    </ul>

                <?php } ?>

            </div>
        </nav>
    </div>
</header>