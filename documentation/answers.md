# WordPress Developer & Marketing Skills Test Answers

## Section 3 – Debugging & Code Quality

Original (Broken) Code
---------------------


function get_recent_posts() {

    $query = new WP_Query('post_type=post&posts_per_page=5');

    while($query->posts) {

        echo '<li>' . $post->title . '</li>';

    }

}



Corrected Code
---------------------

function get_recent_posts() {

    $query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 5
    ]);

    if ( $query->have_posts() ) {

        echo '<ul>';

        while ( $query->have_posts() ) {
            $query->the_post();
            echo '<li>' . esc_html( get_the_title() ) . '</li>';
        }

        echo '</ul>';

        wp_reset_postdata();
    }
}



Explanation of The original code that had several issues:
-----------------------------------------------------------

-Incorrect loop condition
It used $query->posts instead of have_posts(), which breaks the loop logic.

-Missing the_post() call
Without calling the_post(), WordPress does not set the global $post object.

-Invalid post property access
$post->title is incorrect. The correct way is get_the_title().

-No output escaping
Titles were not escaped, which can lead to security issues.

-Missing wp_reset_postdata()
This can break other queries on the page.



## Section 4 – Security Competency
 
 Given Code
 -------------

 if ( isset($_POST['email']) ) {

    $email = $_POST['email'];

    wp_insert_user([

        'user_login' => $email,
        'user_pass'  => $_POST['password'],
        'user_email' => $email

    ]);

}


These are the identified security vulnerabilities below:  
-----------------------------------------------------------

1. No Nonce Verification (CSRF Vulnerability)

The form submission is not protected by a nonce.
This allows Cross-Site Request Forgery (CSRF) attacks.
How to fix: Use wp_nonce_field() in the form and wp_verify_nonce() on submission.


2. No Input Sanitization or Validation

User input (email, password) is used directly.
This can lead to invalid data, injection risks, and corrupted user records.
How to fix: Use sanitize_email(), sanitize_text_field() or wp_unslash()


3. No Capability or Permission Checks

Anyone can submit the form and create a user.
This can lead to unauthorized account creation.
How to fix - Check user capabilities: current_user_can( 'create_users' )


4. Weak Password Handling

Password is passed directly without validation.
No strength checks or confirmation.
How to fix: Validate password length/strength and confirm password fields before inserting.


5. No Error Handling or Duplicate Checks

No check if the email already exists.
Could cause duplicate user errors or overwrite behavior.
How to fix: Use email_exists( $email )


My comments
The code lacks nonce verification, input sanitization, permission checks, and validation. These issues expose the site to CSRF attacks, unauthorized user creation, and data integrity problems. Proper WordPress security practices should always be applied when handling user input.




## Section 5 – Performance & Optimization

Performance & Optimization Plan
--------------------------------------

1. Plugin Audit & Optimization

Audit all 18 active plugins for necessity and performance impact.
Deactivate/remove redundant or unused plugins.
Replace heavy plugins with lightweight alternatives where possible.
Consolidate overlapping plugin functionality.

Reason: Fewer plugins reduce server load, database queries, and front-end script/style conflicts.


2. Theme CSS & JS Optimization

Minify and combine CSS and JS files to reduce HTTP requests.
Defer or asynchronously load non-critical JS.
Remove unused CSS/JS using tools like WP Asset CleanUp or PurgeCSS.
Use a child theme to safely dequeue unnecessary assets.

Reason: Minimizes render-blocking resources and improves page load times.


3. Image Optimization

Compress all existing images to 100–300KB without losing quality.
Convert images to WebP format for better compression.
Implement lazy-loading for images (native or via lightweight plugin).
Resize images to match display dimensions.

Reason: Reduces page size and bandwidth usage, improving both load speed and user experience.


4. Admin-AJAX Optimization

Keep current functionality intact.
Implement caching (transients/object caching) to reduce database hits.

Reason: Reduces server processing while maintaining functionality.


5. Caching & CDN

Enable page caching using a plugin or server-side caching.
Set browser caching for static resources.
Serve static assets via a CDN to reduce latency.

Reason: Reduces server requests and load time, improving global performance.


6. Database Optimization

Clean up post revisions, transients, spam comments, and unused tables.
Optimize database tables using a plugin or manual SQL queries.

Reason: Smaller, efficient database queries reduce server response time.


7. Monitoring & Continuous Improvement

Use tools like GTmetrix, Lighthouse, or PageSpeed Insights to track performance.
Monitor server load and slow queries regularly.
Test any optimization to ensure functionality is intact.

Reason: Performance optimization is iterative; ongoing monitoring ensures consistent speed and SEO benefits.


Expected outcome after the process:
---------------------------------------

Fewer HTTP requests
Smaller page size and faster load times
Reduced server load
Improved Core Web Vitals and SEO performance




## Section 6 – Digital Advertising


Digital Advertising Assessment – Strategy Document
--------------------------------------------------------

6.1 Google Ads: Search Campaign Strategy (WordPress Development Agency)

Campaign Objective:
Generate high-quality leads for WordPress development services.
Target users actively searching for WordPress design, development, and maintenance services.


Suggested Match-Type Keyword List (8 keywords):
WordPress development agency
Hire WordPress developer
WordPress website design
Custom WordPress themes
WordPress plugin development
professional WordPress services
WordPress e-commerce development
Affordable WordPress website


Negative Keywords:
free, template, tutorial, internship, jobs, WordPress course

Sample Ad Copy (Responsive Search Ads):

Ad 1:
Headline 1: Professional WordPress Development
Headline 2: Custom Themes & Plugins
Headline 3: Boost Your Online Presence

Description 1: Launch a fast, responsive WordPress site tailored to your business. Contact our experts today.
Description 2: High-quality WordPress development for agencies, startups, and e-commerce businesses.

Ad 2:
Headline 1: Hire WordPress Experts
Headline 2: Affordable & Reliable Services
Headline 3: Get Your Website Online Fast

Description 1: Build a fully customized WordPress website that converts visitors into customers.
Description 2: Experienced developers, modern designs, and seamless functionality.


Bidding Strategy:
Maximize Conversions with Target CPA (Cost per Acquisition) set based on historical lead cost.
Why: Optimizes budget for lead generation, automatically adjusting bids for best-performing searches.


Landing Page Recommendations:
Dedicated landing page with a clear CTA (e.g., “Request a Quote” / “Book a Free Consultation”)
Showcase portfolio, testimonials, service offerings, and contact form above the fold.
Fast-loading, mobile-responsive, and optimized for Core Web Vitals.



6.2 Troubleshoot a Sudden Drop in Conversions (Google Ads)

Scenario: Campaign dropped from 10–15 conversions/day to 1–2/day.

Possible Causes & Solutions:
Budget exhausted or limited – Check daily budget and increase if needed.
Keyword issues – Investigate negative keywords or reduced search volume; adjust targeting.
Ad disapproval or paused ads – Ensure all ads are active and policy-compliant.
Landing page issues – Check for broken pages, slow load times, or form errors; fix immediately.
Conversion tracking errors – Verify that tracking pixels or Google Tag Manager events are firing correctly.
Increased competition / bid changes – Monitor auction insights and adjust bids or targeting.



6.3 Meta Ads: Audience Strategy (Fitness Equipment E-commerce)

Cold Audiences (New prospects):
Interests: Home Fitness, Gym Equipment, Personal Training
Behaviors: Online Shoppers, Fitness App Users
Lookalike Audience: Users similar to past purchasers (1% lookalike)

Warm Audiences (Engaged):
Website visitors in last 30 days
Social media engagers (Facebook + Instagram) in last 30 days
Newsletter subscribers / email list

Remarketing Audiences:
Add-to-cart but no purchase (last 14 days)
Product viewers who didn’t purchase (last 30 days)


Campaign Objectives & Expected Optimization:

Audience	    Objective	              Optimization Behavior
Cold	        Conversions	              Platform optimizes delivery to likely buyers
Warm	        Conversions / Traffic	      Re-engages users familiar with brand
Remarketing	    Conversions	              High-intent targeting; encourage checkout



6.5 Meta Ads: Creative Testing Framework

Testing Structure:
Number of Creatives: 6–8 per campaign
Structure: Split into 2–3 variations of messaging + 2–3 variations of visuals
Duration: Run tests for 5–7 days or until statistical significance is reached
Validation Criteria: CTR ≥ campaign average, CPC ≤ target, ROAS / conversion rate higher than baseline
Scaling Winners: Increase budget gradually (20–30% every 3–5 days) while keeping ad sets separate for continued monitoring

Why: Systematic testing ensures winning creatives drive higher conversions while minimizing wasted spend.

