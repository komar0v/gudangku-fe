(function () {
    const form = document.getElementById("wizardForm");
    const steps = Array.from(document.querySelectorAll(".form-step"));
    const stepIndicators = Array.from(
        document.querySelectorAll(".step-indicator-item")
    );
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const submitBtn = document.getElementById("submitBtn");

    let currentStep = 0;

    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.classList.toggle("active", index === stepIndex);
        });
        updateStepIndicator(stepIndex);
        updateButtonStates(stepIndex);
        if (stepIndex === steps.length - 1) {
            populateSummary();
        }
    }

    function updateStepIndicator(stepIndex) {
        stepIndicators.forEach((indicator, index) => {
            const circle = indicator.querySelector(".step-circle");
            const label = indicator.querySelector(".step-label");
            const line = indicator.nextElementSibling;

            indicator.classList.remove("active", "completed");
            if (circle) circle.classList.remove("active", "completed");
            if (label) label.classList.remove("active", "completed");

            if (index < stepIndex) {
                indicator.classList.add("completed");
                if (line && line.classList.contains("step-indicator-line")) {
                    line.style.backgroundColor = "#198754";
                }
            } else if (index === stepIndex) {
                indicator.classList.add("active");
                if (line && line.classList.contains("step-indicator-line")) {
                    line.style.backgroundColor = "#adb5bd";
                }
            } else {
                if (line && line.classList.contains("step-indicator-line")) {
                    line.style.backgroundColor = "#adb5bd";
                }
            }
        });

        for (let i = stepIndex; i < stepIndicators.length - 1; i++) {
            const currentIndicator = stepIndicators[i];
            const lineAfterCurrent = currentIndicator.nextElementSibling;
            if (
                lineAfterCurrent &&
                lineAfterCurrent.classList.contains("step-indicator-line")
            ) {
                lineAfterCurrent.style.backgroundColor = "#adb5bd";
            }
        }
    }

    function updateButtonStates(stepIndex) {
        prevBtn.disabled = stepIndex === 0;
        if (stepIndex === steps.length - 1) {
            nextBtn.style.display = "none";
            submitBtn.style.display = "inline-block";
        } else {
            nextBtn.style.display = "inline-block";
            submitBtn.style.display = "none";
        }
    }

    function validateStep(stepIndex) {
        const currentStepInputs = steps[stepIndex].querySelectorAll(
            "input[required], select[required], textarea[required]"
        );
        let isValid = true;

        currentStepInputs.forEach((input) => {
            const parentFormFloating = input.closest(".form-floating");
            if (parentFormFloating) {
                parentFormFloating.classList.add("was-validated");
            } else {
                input.classList.add("was-validated");
            }

            if (input.type === "email") {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value)) {
                    input.setCustomValidity("Format email tidak valid.");
                } else {
                    input.setCustomValidity("");
                }
            }

            if (input.id === "nomerWa") {
                const waRegex = /^[0-9]{8,15}$/;
                if (!waRegex.test(input.value)) {
                    input.setCustomValidity("Nomor WhatsApp tidak valid.");
                } else {
                    input.setCustomValidity("");
                }
            }

            if (!input.checkValidity()) {
                isValid = false;
                input.classList.add("is-invalid");
            } else {
                input.classList.remove("is-invalid");
                input.classList.add("is-valid");
            }
        });

        steps[stepIndex].classList.add("was-validated");
        return isValid;
    }

    function populateSummary() {
        const namaSupplier = document.getElementById("namaSupplier")?.value;
        const nomerWa = document.getElementById("nomerWa")?.value;

        const alamat = document.getElementById("alamat")?.value;
        const tentang = document.getElementById("tentang")?.value;

        document.getElementById("summaryNamaSupplier").textContent =
            namaSupplier || "-";
        document.getElementById("summaryNomerWa").textContent = nomerWa
            ? `+62${nomerWa}`
            : "-";
        document.getElementById("summaryAlamat").textContent = alamat || "-";
        document.getElementById("summaryTentang").textContent = tentang || "-";
    }

    nextBtn.addEventListener("click", () => {
        if (validateStep(currentStep)) {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        } else {
            const firstInvalid = steps[currentStep].querySelector(
                ".is-invalid, :invalid"
            );
            if (firstInvalid) {
                firstInvalid.focus();
            }
        }
    });

    prevBtn.addEventListener("click", () => {
        if (currentStep > 0) {
            steps[currentStep].classList.remove("was-validated");
            steps[currentStep]
                .querySelectorAll(".is-invalid, .is-valid")
                .forEach((el) => {
                    el.classList.remove("is-invalid", "is-valid");
                    const parentFormFloating = el.closest(".form-floating");
                    if (parentFormFloating)
                        parentFormFloating.classList.remove("was-validated");
                });

            currentStep--;
            showStep(currentStep);
        }
    });

    showStep(currentStep);
})();
