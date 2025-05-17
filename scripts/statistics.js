document.addEventListener("DOMContentLoaded", () => {
    // Gender Distribution Chart
    const genderDataElement = document.getElementById("genderData");
    if (genderDataElement) {
        const genderData = JSON.parse(genderDataElement.textContent);
        const genderCtx = document.getElementById("genderChart").getContext("2d");
        new Chart(genderCtx, {
            type: "pie",
            data: genderData,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Comorbidities Chart
    const comorbiditiesDataElement = document.getElementById("comorbiditiesData");
    if (comorbiditiesDataElement) {
        const comorbiditiesData = JSON.parse(comorbiditiesDataElement.textContent);
        const comorbiditiesCtx = document.getElementById("comorbiditiesChart").getContext("2d");
        new Chart(comorbiditiesCtx, {
            type: "doughnut",
            data: comorbiditiesData,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Comorbidities by Gender Chart
    const comorbidityByGenderDataElement = document.getElementById("comorbidityByGenderData");
    if (comorbidityByGenderDataElement) {
        const comorbidityByGenderData = JSON.parse(comorbidityByGenderDataElement.textContent);
        const comorbidityByGenderCtx = document.getElementById("comorbidityByGenderChart").getContext("2d");
        new Chart(comorbidityByGenderCtx, {
            type: "bar",
            data: comorbidityByGenderData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Operations Chart
    const operationsDataElement = document.getElementById("operationsData");
    if (operationsDataElement) {
        const operationsData = JSON.parse(operationsDataElement.textContent);
        const operationsCtx = document.getElementById("operationsChart").getContext("2d");
        new Chart(operationsCtx, {
            type: "bar",
            data: operationsData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Operations by Gender Chart
    const operationByGenderDataElement = document.getElementById("operationByGenderData");
    if (operationByGenderDataElement) {
        const operationByGenderData = JSON.parse(operationByGenderDataElement.textContent);
        const operationByGenderCtx = document.getElementById("operationByGenderChart").getContext("2d");
        new Chart(operationByGenderCtx, {
            type: "bar",
            data: operationByGenderData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Export to PDF functionality
    const exportBtn = document.getElementById('exportPDF');
    if (exportBtn) {
        exportBtn.addEventListener('click', () => {
            const element = document.getElementById('pdfContent');
            // Wait 500ms to ensure all charts are rendered
            setTimeout(() => {
                const opt = {
                    margin:       0.1, // smaller margin
                    filename:     'statistics.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2, useCORS: true },
                    jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
                };
                html2pdf().set(opt).from(element).outputPdf('blob').then(function(pdfBlob) {
                    const blobUrl = URL.createObjectURL(pdfBlob);
                    window.open(blobUrl, '_blank');
                });
            }, 300); // Wait for charts to render
        });
    }
});