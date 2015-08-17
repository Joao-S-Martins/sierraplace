<?php
    $recipient = 'management@sierraplaceapartments.com';
    $type = stripslashes($_POST['type']);
    $firstName = stripslashes($_POST['firstName']);
    $lastName = stripslashes($_POST['lastName']);
    $name = "$firstName $lastName";
    $email = stripcslashes($_POST['email']);
    $phone = stripcslashes($_POST['phone']);
    $bedrooms = stripcslashes($_POST['bedrooms']);
    $pets = stripcslashes($_POST['pets']);
    $moveInDate = stripcslashes($_POST['moveInDate']);
    $tourDate = stripcslashes($_POST['tourDate']);
    $tourTime = stripcslashes($_POST['tourTime']);
    $source = stripcslashes($_POST['source']);
    $comments = stripcslashes($_POST['comments']);
    $subject = "Sierra Place Apartments: $type, $name";
    $msg = "Message from: $name\nEmail: $email\nPhone: $phone\nRequest type: $type\nBedrooms: $bedrooms\nPets: $pets\nTour Date and time: $tourDate $tourTime\nMove-in Date: $moveInDate\nSource: $source\nComments:\n$comments";
    $headers = "From: $recipient\r\n";
    mail($recipient, $subject, $msg);
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