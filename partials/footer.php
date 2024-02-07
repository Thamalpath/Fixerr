        <!-- Footer area start -->
        <footer>
         <div class="footer-main bg-color-1 p-relative">
            <div class="footer-shape-1"
               data-background="assets/imgs/footer/shape-f-1.png"></div>
            <div class="footer-shape-2"
               data-background="assets/imgs/footer/shape-f-2.png"></div>
            <div class="footer-top section-space-medium">
               <div class="small-container">
                  <div class="row g-4">
                     <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-widget-1">
                           <figure class="image" style="width: 50%">
                              <img src="assets/imgs/logo/logo.png" alt>
                           </figure>
                           <p class="mt-40 mb-30">
                           Fixerr can serve as your one-stop solution for the majority of problems that arise in your house. 
                           </p>
                           <div class="working-hours">
                              <h6 class="text-white mb-20">Working Hours:</h6>
                              <ul class="text-white">
                                 <li>Mon - Sat: <span class="fw-lighter">10.00AM
                                       - 4.00PM</span></li>
                                 <li>Sunday: <span class="fw-lighter">Close</span></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-widget-2 pl-50">
                           <h4 class="mb-30 footer-title">Quick Links</h4>
                           <ul class="service-list">
                              <li><a href="about.html">About Us</a></li>
                              <li><a href="team.html">Our Team</a></li>
                              <li><a href="services.html">Our Services</a></li>
                              <li><a href="blog-grid.html">Latest Blog</a></li>
                              <li><a href="contact.html">Contact Us</a></li>
                           </ul>
                        </div>
                     </div>
                     <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-widget-2 pl-50">
                           <h4 class="mb-30 footer-title">Our Services</h4>
                           <ul class="service-list">
                              <li><a href="service-details.html">Damage Roofing</a></li>
                              <li><a href="service-details.html">Roof Repair</a></li>
                              <li><a href="service-details.html">Roof
                                    Installation</a></li>
                              <li><a href="service-details.html">Roof Animation</a></li>
                              <li><a href="service-details.html">Modified
                                    Roofing</a></li>
                           </ul>
                        </div>
                     </div>
                     <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-widget-4 pr-30">
                           <h4 class="mb-20 footer-title mb-30">Our Gallery</h4>
                           <div class="footer-gallery p-relative">
                              <a class="popup-image"
                                 href="assets/imgs/footer/footer-1.png">
                                 <img src="assets/imgs/footer/footer-1.png" alt>
                              </a>
                              <a class="popup-image"
                                 href="assets/imgs/footer/footer-2.png">
                                 <img src="assets/imgs/footer/footer-2.png" alt>
                              </a>
                              <a class="popup-image"
                                 href="assets/imgs/footer/footer-3.png">
                                 <img src="assets/imgs/footer/footer-3.png" alt>
                              </a>
                              <a class="popup-image"
                                 href="assets/imgs/footer/footer-4.png">
                                 <img src="assets/imgs/footer/footer-4.png" alt>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="small-container">
               <div class="footer-bottom pt-30 pb-30">
                  <div class="left-area p-relative">
                     <span>© All Copyright 2023 by <a href="#">Gramen</a></span>
                  </div>
                  <div class="footer-socials p-relative">
                     <span><a href="#"><i class="fab fa-facebook-f"></i></a></span>
                     <span><a href="#"><i class="fab fa-twitter"></i></a></span>
                     <span><a href="#"><i class="fab fa-linkedin-in"></i></a></span>
                     <span><a href="#"><i class="fab fa-youtube"></i></a></span>
                  </div>
                  <div class="right-area p-relative">
                     <span><a href="#">Terms & Condition</a></span>
                     <span><a href="#">Privacy Policy</a></span>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- Footer area end -->

      <!-- JS here -->
      <script src="assets/js/jquery-3.6.0.min.js"></script>
      <script src="assets/js/waypoints.min.js"></script>
      <script src="assets/js/bootstrap.bundle.min.js"></script>
      <script src="assets/js/meanmenu.min.js"></script>
      <script src="assets/js/swiper.min.js"></script>
      <script src="assets/js/slick.min.js"></script>
      <script src="assets/js/magnific-popup.min.js"></script>
      <script src="assets/js/counterup.js"></script>
      <script src="assets/js/wow.js"></script>
      <script src="assets/js/main.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/js/fontawesome.min.js"></script>

      <!-- Add this script to initialize Notyf.js -->
      <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
      <script>
         // Initialize Notyf
         const notyf = new Notyf({
               duration: 3000,
               position: {
                  x: 'right',
                  y: 'top',
               },
         });

         <?php
         // Display success or error alerts
         if (isset($_SESSION['success'])) {
               echo "notyf.success('{$_SESSION['success']}');";
               unset($_SESSION['success']); 
         }

         if (isset($_SESSION['error'])) {
               echo "notyf.error('{$_SESSION['error']}');";
               unset($_SESSION['error']); 
         }
         ?>
      </script>
    </body>

</html>