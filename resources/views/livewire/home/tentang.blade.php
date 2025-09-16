<div>

    <livewire:PartialView.HomeIndex.Header />

    <main class="main">

        <!-- About Section -->
        <section id="about" class="about section dark-background">

            <div class="container section-title" data-aos="fade-up">
                <h2>Tentang</h2>
                <div><span>Mengenai</span> <span class="description-title">Kami</span></div>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="200">
                        <div class="about-image">
                            <img src="{{ url(env('ASSET_URL') . 'assets/img/about/tentangpage.png') }}" class="img-fluid main-image">
                            <div class="experience-badge">
                                <span class="years">5+</span>
                                <span class="text">Years of Experience</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="about-content">
                            <h2>Kenapa Pilih Emping Melinjo?</h2>
                            <p class="lead">Camilan tradisional yang renyah, gurih, dan penuh cita rasa Nusantara. Dibuat dari bahan pilihan, Emping Melinjo cocok jadi teman santai maupun hidangan spesial keluarga.</p>

                            <div class="row features-row">
                                <div class="col-md-6">
                                    <div class="feature-item">
                                        <div class="icon">
                                            <i class="bi bi-graph-up-arrow"></i>
                                        </div>
                                        <h4>Kualitas Premium</h4>
                                        <p>Dibuat dari biji melinjo pilihan, diproses higienis untuk menjaga rasa dan tekstur.</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="feature-item">
                                        <div class="icon">
                                            <i class="bi bi-lightbulb"></i>
                                        </div>
                                        <h4>Rasa Autentik</h4>
                                        <p>Renyah dan gurih khas emping asli Indonesia, dengan cita rasa yang tak tergantikan.</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="feature-item">
                                        <div class="icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <h4>Cocok Untuk Semua</h4>
                                        <p>Sajian pas untuk keluarga, acara spesial, maupun sekadar camilan santai sehari-hari.</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="feature-item">
                                        <div class="icon">
                                            <i class="bi bi-trophy"></i>
                                        </div>
                                        <h4>Produk Terpercaya</h4>
                                        <p>Dipercaya banyak pelanggan karena kualitas dan rasa konsisten dari waktu ke waktu.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </section><!-- /About Section -->

    </main>
    <livewire:PartialView.HomeIndex.Footer />
</div>