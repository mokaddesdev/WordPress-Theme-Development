 <?php
    /**
     * Template Name: Main Section
     * 
     * @package lessonlms
     */

    echo '<div class="" style="margin-top: -60px">';
    get_header();
    echo '</div>';

    get_template_part('template-parts/single-course/breadcrumb');

    $post_id = get_the_ID();

    $total_enrolled_student = get_post_meta( $post_id, '_enrolled_students', true) ?: 0;

    ?>

 <section class="single-courses">
     <div class="container">
         <!-- course title -->
         <h2 class="course-heading">
             <?php echo esc_html(get_the_title($post_id)); ?>
         </h2>
         <div class="average-rating-student">
             <div class="student">
                 <?php
                    $stats = lessonlms_get_review_stats($post_id);
                    $total_reviews = $stats['total_reviews'];
                    $avg_rating = $stats['average_rating'];
                    ?>
                 <?php for ($i = 1; $i <= 5; $i++) : ?>
                     <?php if ($i <= $avg_rating): ?>
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                         </svg>
                     <?php elseif ($i - 0.5 <= $avg_rating): ?>
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                             <defs>
                                 <!-- Gradient fill: 50% yellow, 50% gray -->
                                 <linearGradient id="half-yellow" x1="0" x2="100%" y1="0" y2="0">
                                     <stop offset="50%" stop-color="yellow" />
                                     <stop offset="50%" stop-color="lightgray" />
                                 </linearGradient>
                             </defs>

                             <path fill="url(#half-yellow)" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                 d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442
                    c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385
                    a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54
                    a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602
                    a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                         </svg>


                     <?php else: ?>
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                         </svg>

                     <?php endif; ?>

                 <?php endfor; ?>

                 <span class="average-rating-count">
                    <?php echo esc_html($avg_rating); ?>
                </span>
                 <h4>(<span class="total-reviews-count">
                    <?php echo esc_html($total_reviews); ?>
                </span> reviews)
              </h4>

             </div>

             <div class="student">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                     <path stroke-linecap="round" stroke-linejoin="round"
                         d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                 </svg>

                 <h4 class="student-entrolled"> <?php echo number_format($total_enrolled_student) ?> student enrolled</h4>

             </div>

             <div class="course-category">
                <h4>Category: Web Development</h4>
             </div>

             <div class="course-level">
                <h4> Level: Intermediate </h4>
             </div>
         </div>

         <div class="single-courses-wrapper">

             <!-- left -->
             <div class="left-courses-image-details">
                 <?php get_template_part('template-parts/single-course/price-image', 'card'); ?>

                <?php get_template_part('template-parts/single-course/tabs/tab'); ?>

                 <div class="courses-tab-content" id="overview">
                     <?php get_template_part('template-parts/single-course/tabs/overview'); ?>
                 </div>
                 
                 <div class="courses-tab-content" id="curriculum">
                     <?php get_template_part('template-parts/single-course/tabs/curriculum'); ?>
                </div>
                 <div class="courses-tab-content" id="instructor">Instructor Content</div>

                 <?php get_template_part('template-parts/single-course/tabs/review'); ?>

             </div>
             <!-- right -->
             <div class="courses-card-right">

                 <!-- first card -->
                 <?php get_template_part('template-parts/single-course/details'); ?>

                 <!-- second card -->
                 <div class="course-right-info-card2">
                     <h2>Who this course is for:</h2>
                     <div class="course-right-info-card2-items item1">

                         <?php get_template_part('template-parts/single-course/svg/check-icon', 'svg'); ?>


                         <div class="text">
                             <span>Aspiring UI/UX designers</span>
                         </div>
                     </div>

                     <div class="course-right-info-card2-items item2">
                        <?php get_template_part('template-parts/single-course/svg/check-icon', 'svg'); ?>
                         <div class="text">
                             <span>Web developers wanting design skills</span>
                         </div>
                     </div>

                     <div class="course-right-info-card2-items item3">
                        <?php get_template_part('template-parts/single-course/svg/check-icon', 'svg'); ?>

                         <div class="text">
                             <span>Graphic desiners transitioning to digital</span>
                         </div>
                     </div>

                     <div class="course-right-info-card2-items item4">
                         <?php get_template_part('template-parts/single-course/svg/check-icon', 'svg'); ?>
                         <div class="text">
                             <span>Products manager</span>
                         </div>
                     </div>
                 </div>

             </div>
         </div>
     </div>
 </section>


 <script>
     document.querySelectorAll('button.enroll-btn').forEach(button => {
         button.addEventListener('click', function() {
             const courseId = this.getAttribute('data-course-id');
             const courseElement = document.querySelector('.student-entrolled');
             const loginUrl = "<?php echo esc_url(wp_login_url()); ?>";

             const startLearningUrl = "<?php echo esc_url(home_url("/start-your-learning/?course_id=" . get_the_ID()));

            ?>"

              const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            customClass: {
                                popup: 'custom-toast'
                            },
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                            });



             fetch(ajax_object.ajaxurl, {
                     method: "POST",
                     headers: {
                         "Content-Type": "application/x-www-form-urlencoded",
                     },
                     body: 'action=lessonlms_enroll_course&course_id=' + courseId + '&nonce=' + ajax_object.nonce
                 })
                 .then(response => response.json())
                 .then(data => {
                    
                    if (!data.success && data.data === 'Already enrolled') {
                          window.location.href = startLearningUrl;
                           return;
                          }

                     if (data.success) {
                         this.disabled = false;
                         this.style.cursor = "pointer";
                         this.innerHTML = `<a href="${startLearningUrl}"  class=""> Start Learning </a>`;
                         document.querySelector(".review-warning").style.display = "none";
                          document.querySelector(".student-form-wrapper").style.display = "block";
                            Toast.fire({
                            icon: "success",
                            title: "Course Purchase in successfully",
                            });
                     } else {
                         if (data.data === 'Please login first to enroll') {
                        Swal.fire({
                        title: "Please login first to enroll",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Login Now",
                        cancelButtonText: "Cancel"
                        }).then( (result) =>{
                            if (result.isConfirmed) {
                              window.location.href = loginUrl; 
                           }

                        });
                           
                         } else {
                            Toast.fire({
                                icon: "error",
                                title:"Enrollment Unsuccessful"
                            })
                         }
                     }
                 })
                 .catch(error => {
                    //  console.error('Error:', error);
                        Swal.fire({
                        title: "Oh! Try Again for Enrollment?",
                        text: "Please login first to enroll",
                        icon: "question"
                        });
                 });
         });
     });
 </script>


 <?php
 //? load svg file
    get_template_part('template-parts/single-course/svg/all-svg');
  get_footer();
  ?>