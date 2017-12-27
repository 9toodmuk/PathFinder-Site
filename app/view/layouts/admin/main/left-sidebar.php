            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="/admin/"><i class="fa fa-dashboard fa-fw"></i> <?=$lang['Dashboard']?></a>
                        </li>
                        <li>
                            <a href="#stats"><i class="fa fa-bar-chart-o fa-fw"></i> <?=$lang['Stats']?></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> <?=$lang['Manage']?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/employer/"><?=$lang['Employers']?></a>
                                </li>
                                <li>
                                    <a href="#"><?=$lang['Categories']?> <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="/admin/categories/employer/"><?=$lang['Employers']?></a>
                                        </li>
                                        <li>
                                            <a href="/admin/categories/job/"><?=$lang['Jobs']?></a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="/admin/postings/"><?=$lang['Postings']?></a>
                                </li>
                                <li>
                                    <a href="/admin/applications/"><?=$lang['Applications']?></a>
                                </li>
                                <li>
                                    <a href="/admin/users/"> <?=$lang['Users']?></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
