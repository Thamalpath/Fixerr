<?php
    // Check if a user is signed in
    if (isset($_SESSION['user_type'])) {
        // If a staff member is signed in
        if ($_SESSION['user_type'] === 'customer') {
            ?>
            <header>
               <div id="header-sticky" class="header-area header-style-two">
                  <div class="large-container">
                     <div class="mega-menu-wrapper">
                        <div class="header-main">
                           <div class="header-left">
                              <div class="header-logo">
                                 <a href="index.php">
                                    <img src="assets/imgs/logo/logo.png"
                                       alt="header logo">
                                 </a>
                              </div>
                           </div>
                           <div class="header-right d-flex justify-content-end">
                              <div class="mean__menu-wrapper d-none d-lg-block">
                                 <div class="main-menu">
                                    <nav id="mobile-menu">
                                       <ul>
                                          <li>
                                             <a href="account.php">Account</a>
                                          </li>
                                          <li>
                                             <a href="inbox.php">Inbox</a>
                                          </li>
                                          <li>
                                             <a href="category.php">Category</a>
                                          </li>
                                          <li class="has-dropdown active">
                                             <a>Welcome <?= $_SESSION['user_data']['fname']?></a>
                                          </li>
                                       </ul>
                                    </nav>
                                    <!-- for wp -->
                                    <div class="header__hamburger ml-50 d-none">
                                       <button type="button"
                                          class="hamburger-btn offcanvas-open-btn">
                                          <span>01</span>
                                          <span>01</span>
                                          <span>01</span>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                              <div class="search-toggle-open header-search my-auto">
                                 <div class="search-icon">
                                    <i class="icon-search"></i>
                                 </div>
                              </div>
                              <div class="header-action d-none d-xl-inline-flex gap-5">
                                 <div class="header-link">
                                    <a class="primary-btn-1 btn-hover"
                                       href="logout.php">
                                       LOG OUT &nbsp; | <i
                                          class="icon-right-arrow"></i>
                                       <span style="top: 147.172px; left: 108.5px;"></span>
                                    </a>
                                 </div>
                              </div>
                              <div class="header__hamburger d-xl-none my-auto">
                                 <div class="sidebar__toggle">
                                    <a class="bar-icon" href="javascript:void(0)">
                                       <i class="fa-light fa-bars-sort"></i>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </header>
         <?php   
        }
        // If a driver is signed in
        elseif ($_SESSION['user_type'] === 'professional') {
            ?>
            <header>
               <div id="header-sticky" class="header-area header-style-two">
                  <div class="large-container">
                     <div class="mega-menu-wrapper">
                        <div class="header-main">
                           <div class="header-left">
                              <div class="header-logo">
                                 <a href="index.php">
                                    <img src="assets/imgs/logo/logo.png"
                                       alt="header logo">
                                 </a>
                              </div>
                           </div>
                           <div class="header-right d-flex justify-content-end">
                              <div class="mean__menu-wrapper d-none d-lg-block">
                                 <div class="main-menu">
                                    <nav id="mobile-menu">
                                       <ul>
                                          <li>
                                             <a href="account.php">Account</a>
                                          </li>
                                          <li>
                                             <a href="inbox.php">Inbox</a>
                                          </li>
                                          <li>
                                             <a>Services</a>
                                             <ul class="submenu">
                                                <li><a href="service-add.php">Add-Service</a></li>
                                                <li><a href="pro-services.php">Services</a></li>
                                             </ul>
                                          </li>
                                          <li class="has-dropdown active">
                                             <a>Welcome <?= $_SESSION['user_data']['fname']?></a>
                                          </li>
                                       </ul>
                                    </nav>
                                    <!-- for wp -->
                                    <div class="header__hamburger ml-50 d-none">
                                       <button type="button"
                                          class="hamburger-btn offcanvas-open-btn">
                                          <span>01</span>
                                          <span>01</span>
                                          <span>01</span>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                              <div class="search-toggle-open header-search my-auto">
                                 <div class="search-icon">
                                    <i class="icon-search"></i>
                                 </div>
                              </div>
                              <div class="header-action d-none d-xl-inline-flex gap-5">
                                 <div class="header-link">
                                    <a class="primary-btn-1 btn-hover"
                                       href="logout.php">
                                       LOG OUT &nbsp; | <i
                                          class="icon-right-arrow"></i>
                                       <span style="top: 147.172px; left: 108.5px;"></span>
                                    </a>
                                 </div>
                              </div>
                              <div class="header__hamburger d-xl-none my-auto">
                                 <div class="sidebar__toggle">
                                    <a class="bar-icon" href="javascript:void(0)">
                                       <i class="fa-light fa-bars-sort"></i>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </header>
         <?php
        }
    } else {
    // User is not signed in, display the default menu
    ?>
   <!-- Header area start -->
   <header>
      <div id="header-sticky" class="header-area header-style-two">
         <div class="large-container">
            <div class="mega-menu-wrapper">
               <div class="header-main">
                  <div class="header-left">
                     <div class="header-logo">
                        <a href="index.php">
                           <img src="assets/imgs/logo/logo.png"
                              alt="header logo">
                        </a>
                     </div>
                  </div>
                  <div class="header-right d-flex justify-content-end">
                     <div class="mean__menu-wrapper d-none d-lg-block">
                        <div class="main-menu">
                           <nav id="mobile-menu">
                              <ul>
                                 <li class="has-dropdown active">
                                    <a href="index.php">Home</a>
                                 </li>
                                 <li>
                                    <a href="#about">About</a>
                                 </li>
                                 <li>
                                    <a href="category.php">Category</a>
                                 </li>
                                 <li>
                                    <a href="contact.php">Contact</a>
                                 </li>

                              </ul>
                           </nav>
                           <!-- for wp -->
                           <div class="header__hamburger ml-50 d-none">
                              <button type="button"
                                 class="hamburger-btn offcanvas-open-btn">
                                 <span>01</span>
                                 <span>01</span>
                                 <span>01</span>
                              </button>
                           </div>
                        </div>
                     </div>
                     <div class="search-toggle-open header-search my-auto">
                        <div class="search-icon">
                           <i class="icon-search"></i>
                        </div>
                     </div>
                     <div class="header-action d-none d-xl-inline-flex gap-5">
                        <div class="header-link">
                           <a class="primary-btn-1 btn-hover"
                              href="signin.php">
                              SIGN IN &nbsp; | <i
                                 class="icon-right-arrow"></i>
                              <span style="top: 147.172px; left: 108.5px;"></span>
                           </a>
                        </div>
                     </div>
                     <div class="header__hamburger d-xl-none my-auto">
                        <div class="sidebar__toggle">
                           <a class="bar-icon" href="javascript:void(0)">
                              <i class="fa-light fa-bars-sort"></i>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </header>
   <!-- Header area end -->
   <?php
    }
   ?>