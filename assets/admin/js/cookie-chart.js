document.addEventListener('DOMContentLoaded', function() {
    // Elfogadás / Elutasítási Arányok
    const ctxAcceptanceRates = document.getElementById('cookieChartAcceptanceRates').getContext('2d');
    new Chart(ctxAcceptanceRates, {
        type: 'pie',
        data: {
            labels: [
                cookieStatsLabels.allAccepted,
                cookieStatsLabels.necessaryOnly
            ],
            datasets: [{
                data: [
                    cookieStatsData.allAccepted,
                    cookieStatsData.acceptanceTypes.necessaryOnly
                ],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    document.getElementById('legendAcceptanceRates').innerHTML = `
        <div class="chart-legend-types">
            <div class="legend-item">
                <span class="legend-color" style="background-color: #28a745;"></span>
                <span class="legend-text">${cookieStatsLabels.allAccepted}</span>
            </div>
            <div class="legend-item">
                <span class="legend-color" style="background-color: #dc3545;"></span>
                <span class="legend-text">${cookieStatsLabels.allRejected}</span>
            </div>
        </div>
    `;

    // Elfogadási Típusok
    const ctxAcceptanceTypes = document.getElementById('cookieChartAcceptanceTypes').getContext('2d');
    new Chart(ctxAcceptanceTypes, {
        type: 'pie',
        data: {
            labels: [
                cookieStatsLabels.allAccepted,
                cookieStatsLabels.necessaryOnly,
                cookieStatsLabels.necessaryMarketing,
                cookieStatsLabels.necessaryStatistics
            ],
            datasets: [{
                data: [
                    cookieStatsData.allAccepted,
                    cookieStatsData.acceptanceTypes.necessaryOnly,
                    cookieStatsData.acceptanceTypes.necessaryMarketing,
                    cookieStatsData.acceptanceTypes.necessaryStatistics
                ],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#007bff']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    document.getElementById('legendAcceptanceTypes').innerHTML = `
    <div class="chart-legend-types">
        <div class="legend-item">
            <span class="legend-color" style="background-color: #28a745;"></span>
            <span class="legend-text">${cookieStatsLabels.allAccepted}</span>
        </div>
        <div class="legend-item">
            <span class="legend-color" style="background-color: #dc3545;"></span>
            <span class="legend-text">${cookieStatsLabels.necessaryOnly}</span>
        </div>
        <div class="legend-item">
            <span class="legend-color" style="background-color: #ffc107;"></span>
            <span class="legend-text">${cookieStatsLabels.necessaryMarketing}</span>
        </div>
        <div class="legend-item">
            <span class="legend-color" style="background-color: #007bff;"></span>
            <span class="legend-text">${cookieStatsLabels.necessaryStatistics}</span>
        </div>
    </div>
    `;
});
