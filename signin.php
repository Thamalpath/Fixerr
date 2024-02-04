<?php include('partials/header.php'); ?>

<style>
.text-base{
    color: #ea1826;
}
</style>

<main>
   
 <!-- Breadcrumb area start --> 
<div class="breadcrumb__area theme-bg-1 p-relative pt-160 pb-160">
   <div class="breadcrumb__thumb" data-background="assets/imgs/resources/page-title-bg-1.jpg"></div>
   <div class="breadcrumb__thumb_3" data-background="assets/imgs/shapes/shape-53.png"></div>
   <div class="small-container">
      <div class="row justify-content-center">
         <div class="col-xxl-12">
            <div class="breadcrumb__wrapper p-relative">
               <h2 class="breadcrumb__title">Sign In</h2>
               <div class="breadcrumb__menu">
                  <nav>
                     <ul>
                        <li><span><a href="index.php">Home</a></span></li>
                        <li><span>Sign In</span></li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
 <!-- Breadcrumb area end --> 


 <section class="contact-page-section section-space">
   <div class="small-container">
      <div class="row justify-content-center">
         <div class="col-xxl-6 col-xl-6 col-lg-6 mx-auto"> 
            <div class="contact-page-form-area">
               <div class="title-box mb-40 wow fadeInLeft" data-wow-delay=".5s">
                  <span class="section-sub-title">Sign In</span>
                  <h3 class="section-title mt-10">Sign in to Your Account</h3>
               </div>
               <div class="contact-page-form">
                    <form class="account-form" method="post">
                        <div class="row mb-10-none">
                           <div class="col-lg-12">
                                <label>Email</label>
                                <input type="email" placeholder="Email" name="email" required>
                            </div>
                            <div class="col-lg-12">
                                <label>Password</label>
                                <input type="password" placeholder="Password" name="password" required>
                            </div>
                            <div class="col-lg-12 form-group text-center mt-10">
                                <button  type="submit" class="primary-btn-1 btn-hover w-100">
                                    Sign In &nbsp; | <i class="icon-right-arrow"></i>
                                    <span style="top: 147.172px; left: 108.5px;"></span>
                                </button>
                            </div>
                            <div class="col-lg-12 text-center">
                                <div class="account-item mt-30">
                                    <label>Not Register Yet? <a href="signup.php" class="text-base">Create
                                            an account</a></label>
                                </div>
                            </div>
                        </div>
                    </form>
               </div>
            </div>
         </div>
      </div>
   </div>
 </section>

</main>

<!-- Footer area start -->
<?php include('partials/footer.php'); ?>