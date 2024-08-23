
<div class="page-section">
    <div class="container">
      <h1 class="text-center mb-5 wow fadeInUp">Our Doctors</h1>

      <div class="owl-carousel wow fadeInUp" id="doctorSlideshow">

         <!--Display the doctor after admin add_doctor-->

        @foreach($doctor as $doctors)

        <div class="item">
          <div class="card-doctor">
            <div class="header">
              <img height="300px" src="doctorimage/{{ $doctors->image }}" alt="">
              <div class="meta">
                <a href="#"><span class="mai-call"></span></a>
                <a href="#"><span class="mai-logo-whatsapp"></span></a>
              </div>
            </div>
            <div class="body">
            <!--Get add_doctor data from the database-->
              <p class="text-xl mb-0">{{ $doctors->name }}</p>
              <span class="text-sm text-grey">{{ $doctors->specialty}}</span>
            </div>
          </div>
        </div>

        @endforeach

      </div>
    </div>
  </div>    