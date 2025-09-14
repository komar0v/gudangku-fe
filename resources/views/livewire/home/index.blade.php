<div>

    <livewire:PartialView.HomeIndex.Header />

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                            <h2>Emping Melinjo Merapi</h2>
                            <p>Rasakan renyahnya emping melinjo khas lereng Merapi. Dibuat dari bahan pilihan, diolah secara tradisional, dan dipercaya ratusan pelanggan setiap bulannya.</p>
                            <div class="hero-btns">
                                <a wire:navigate href="{{ route('tentangPage') }}" class="btn btn-primary">Tentang Kami</a>
                                <a wire:navigate href="{{ route('layananPage') }}" class="btn btn-outline">Blog</a>
                            </div>
                            <div class="hero-stats">
                                <div class="stat-item">
                                    <h3><span data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1" class="purecounter"></span>+</h3>
                                    <p>Order per bulan</p>
                                </div>
                                <div class="stat-item">
                                    <h3><span data-purecounter-start="0" data-purecounter-end="500" data-purecounter-duration="1" class="purecounter"></span>+</h3>
                                    <p>Pelanggan</p>
                                </div>
                                <div class="stat-item">
                                    <h3><span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>+</h3>
                                    <p>Negara Export</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                            <img src="assets/img/about/about-21.webp" alt="Consulting Services" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- Work Process Section -->
        <section id="work-process" class="work-process section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Proses Kami</h2>
                <div>Dari bahan pilihan hingga emping renyah siap dinikmati.</div>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row">
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="steps-content">
                            <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                                <img src="assets/img/about/about-21.webp" alt="Consulting Services" class="img-fluid">
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="300">
                        <div class="steps-list">
                            <div class="step-item">
                                <div class="step-number">01</div>
                                <div class="step-content">
                                    <h3>Pemilihan Bahan Baku</h3>
                                    <p>Kami hanya menggunakan biji melinjo terbaik yang dipanen langsung dari petani lokal.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">02</div>
                                <div class="step-content">
                                    <h3>Pengolahan Tradisional</h3>
                                    <p>Proses ditumbuk, dipipihkan, dan dijemur masih menggunakan cara tradisional untuk menjaga cita rasa otentik.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">03</div>
                                <div class="step-content">
                                    <h3>Pengeringan Alami</h3>
                                    <p>Emping dijemur di bawah sinar matahari, sehingga lebih sehat, awet, dan bebas dari bahan kimia berbahaya.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">04</div>
                                <div class="step-content">
                                    <h3>Pengemasan Higienis</h3>
                                    <p>Emping dikemas rapi dan higienis agar kualitas tetap terjaga sampai di tangan pelanggan.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">05</div>
                                <div class="step-content">
                                    <h3>Siap Dinikmati</h3>
                                    <p>Emping Melinjo Merapi siap jadi camilan renyah maupun pelengkap hidangan khas Nusantara.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section><!-- /Work Process Section -->

    </main>
    <livewire:PartialView.HomeIndex.Footer />
</div>