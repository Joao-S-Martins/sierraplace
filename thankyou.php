<?php
    // Emails a submission from one of the site's forms (request-information, schedule-tour,
    // rental-forms, contact-us, work-order) to the management office, then shows the page below.
    // Written for PHP 5.4 and later, since the host's PHP version isn't pinned.
    $recipient = 'management@sierraplaceapartments.com';

    // A single-line form value: line breaks removed (in the subject or headers they would let a
    // visitor add mail headers), trimmed and length-limited. Missing fields become ''.
    function form_line($key, $max = 200) {
        $value = isset($_POST[$key]) && is_string($_POST[$key]) ? $_POST[$key] : '';
        $value = trim(preg_replace('/[\x00-\x1F\x7F]+/', ' ', $value));
        return function_exists('mb_substr') ? mb_substr($value, 0, $max, 'UTF-8') : substr($value, 0, $max);
    }

    // A multi-line form value (comments): line breaks normalized to \n, other control
    // characters removed, length-limited.
    function form_text($key, $max = 5000) {
        $value = isset($_POST[$key]) && is_string($_POST[$key]) ? $_POST[$key] : '';
        $value = str_replace(array("\r\n", "\r"), "\n", $value);
        $value = trim(preg_replace('/[\x00-\x08\x0B-\x1F\x7F]+/', ' ', $value));
        return function_exists('mb_substr') ? mb_substr($value, 0, $max, 'UTF-8') : substr($value, 0, $max);
    }

    $types = array(
        'request-information' => 'Information request',
        'schedule-tour' => 'Tour request',
        'rent-now' => 'Rental inquiry',
        'contact-us' => 'Contact form',
        'work-order' => 'Work order',
    );
    $type = form_line('type', 50);
    $typeLabel = isset($types[$type]) ? $types[$type] : 'Website form';

    $name = trim(form_line('firstName', 100) . ' ' . form_line('lastName', 100));
    $email = form_line('email', 254);
    $phone = form_line('phone', 50);
    $comments = form_text('comments');
    $pets = form_line('pets', 10);
    $pets = $pets === 'true' ? 'Yes' : ($pets === 'false' ? 'No' : $pets);

    // Only real submissions send mail: a POST with the hidden "priority" field left empty
    // (it's hidden with CSS, so only bots fill it in) and some way to identify the sender.
    // Plain visits to this page (links, crawlers) and empty forms send nothing.
    $isSubmission = isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST'
        && form_line('priority') === ''
        && ($name !== '' || $email !== '' || $phone !== '' || $comments !== '');

    if ($isSubmission) {
        $fields = array(
            'Request type' => $typeLabel,
            'Name' => $name,
            'Email' => $email,
            'Phone' => $phone,
            'Apartment number' => form_line('unit', 20),
            'Maintenance category' => form_line('category', 100),
            // Unchecked checkboxes aren't posted, so say "No" explicitly on work orders.
            'Permission to enter' => $type === 'work-order' ? (isset($_POST['permissionToEnter']) ? 'Yes' : 'No') : '',
            'Bedrooms' => form_line('bedrooms', 10),
            'Pets' => $pets,
            'Tour date and time' => trim(form_line('tourDate', 20) . ' ' . form_line('tourTime', 20)),
            'Move-in date' => form_line('moveInDate', 20),
            'Heard about us from' => form_line('source', 100),
        );
        $msg = '';
        foreach ($fields as $label => $value) {
            if ($value !== '') {
                $msg .= "$label: $value\n";
            }
        }
        $msg .= "\nComments:\n" . ($comments !== '' ? $comments : '(none)') . "\n";

        // Non-ASCII names (é, ñ) need MIME encoding in the subject. One encoded word, with no
        // line folding, so mail() never receives a subject containing a line break.
        $subject = 'Sierra Place Apartments: ' . $typeLabel . ($name !== '' ? ", $name" : '');
        if (preg_match('/[^\x20-\x7E]/', $subject)) {
            $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        }

        $headers = array(
            "From: Sierra Place Website <$recipient>",
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
        );
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $headers[] = "Reply-To: $email";
        }

        if (!mail($recipient, $subject, $msg, implode("\r\n", $headers))) {
            error_log("thankyou.php: mail() failed for a $typeLabel submission");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    


<head>
        
        <title>Thank You | Apartments for rent in Porterville CA</title>
    <meta name="format-detection" content="telephone=no">
        
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <link rel="stylesheet" href="css/custom.min0ff5.css?v=1.0.2">
    </head>
    <body style>
        
<div style="background-image:url('index-photos/pool-aerial-view.jpg');background-repeat:no-repeat;background-size:cover; background-position:center;">
    <div class='container' style="padding-left: 0; padding-right: 0;">
      <div itemscope itemtype='http://schema.org/LocalBusiness' class='info col-md-4 text-center' style="margin-top: 10px; margin-bottom: 70px; padding-bottom: 10px; padding: 15px; background-color: rgba(255,255,255,.8);">
                <span style='display: none;' itemprop="name">Sierra Place</span>
          <h2>
              <a href="index.html">
                  <img itemprop="logo" src="logo.png" style="margin-right: auto; margin-left: auto;" alt="Sierra Place Apartment Community - Porterville, California" title="Sierra Place"
                       class="img-responsive"/>
              </a>
          </h2>

          <a class="logo_to_map"
             href='http://maps.google.com/maps?saddr=My+Location&amp;daddr=333%20N.%20Indiana%20Street,Porterville,California'
             target='_blank'>
              <address style="font-size: 1.1em;" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                  <span class="glyphicon glyphicon-map-marker" style="font-size: medium;"></span>
                  <span itemprop="streetAddress">333 N. Indiana Street</span>, <span itemprop="addressLocality">Porterville</span>, <span itemprop="addressRegion">CA</span> <span itemprop='postalCode'>93257</span>
              </address>
                        <span style="display: none;" itemprop="url">sierraplaceapartments.com</span>
          </a>
                <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                    <meta itemprop="latitude" content="36.071288" />
                    <meta itemprop="longitude" content="-119.03577" />
                </div>
          <div>
              <a class='btn btn-info btn-lg btn-block' href='request-information.html'><span
                      class="glyphicon glyphicon-info-sign" style="padding-right: 5px;"></span>Request Information</a>

              <a class='btn btn-info btn-lg btn-block' href='schedule-tour.html'><span
                      class="glyphicon glyphicon-calendar" style="padding-right: 5px;"></span>Schedule a Tour</a>

            <a class='btn btn-primary btn-md btn-block pull-left' data-call-to-action='Click to Call' href='tel:(559) 781-8000'
               style="width: 48%; margin-right: 4%;">
                             <span class="glyphicon glyphicon-earphone" style="padding-right: 5px;"></span><span itemprop="telephone">(559) 781-8000</span></a>

              <a class='btn btn-primary btn-md btn-block pull-right call-to-action' data-call-to-action='Click to Email' href='mailto:management@sierraplaceapartments.com' style="width: 48%;">
                  <span class="glyphicon glyphicon-envelope" style="padding-right: 5px;"></span>Email
              </a>
          </div>
          
      </div>
    </div>
</div>


<div class='container property'>
    
    <div class="subnav">
    <div class="centered-pills">
    <ul class="nav nav-pills" style="font-size: 1.2em; font-weight: bold;">
        
        <li class="active">
            <a href="index.html">Our Community</a>
        </li>
        
        <li>
            <a href="gallery.html">Photos</a>
        </li>
        
        <li>
            <a href="amenities.html">Amenities</a>
        </li>
        
        <li>
            <a href="floorplans-pricing.html">Floor Plans</a>
        </li>
        
        <li>
            <a href="rental-forms.html">Rental Forms</a>
        </li>
        
        <li>
            <a href="the-area.html">The Area</a>
        </li>
        
    </ul>
    </div>
</div>
    
</div>

<div class="container property-container">
    
        <h1>Thank You</h1>
        <h2><strong><em>Apartments for Rent in Porterville, CA</em></strong></h2>
        

    <div class="col-xs-12 lead">
        
        <p>Our management will be contacting you by phone or email as soon as possible. Thanks again for your interest in our luxurious community!</p>

        
    </div>
</div>



    </div>
</div>
        <footer>
    <div class='container'>
        <div class="row">
            <div style="display: inline-block; width: 42px; height: 42px; float: left;">
                <img src="../../../img/equal_housing%402x.png" id="equalhousing" alt="Equal Housing Opportunity"
                     title="It is the policy of this community to comply with all applicable fair housing laws including those which prohibit discrimination against any person based on race, sex, religion, color, familial status, national origin or handicap."/>
            </div>
            <ul class="list-inline text-center"></ul>
        </div>
    </div>
    <div class='row text-center'
         style='color:#c9c9c9; background-color: #303030; padding: 8px 0; margin-left: 0; margin-right: 0;'></div>
</footer>
        <script data-main="/js/optimized.js?v=1.0.2" src="/js/require.js" async></script>
    </body>


</html>