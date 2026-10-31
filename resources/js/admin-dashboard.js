
document.addEventListener('DOMContentLoaded', () => {
    const data = window.dashboardChartData || {};

    const donationData = data.donations || [];
    const categoryData = data.categories || [];

    const rupiah = (value) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(value);
    };

    const compactRupiah = (value) => {
        if (value >= 1000000000) {
            return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
        }

        if (value >= 1000000) {
            return 'Rp ' + (value / 1000000).toFixed(1) + ' jt';
        }

        if (value >= 1000) {
            return 'Rp ' + (value / 1000).toFixed(0) + ' rb';
        }

        return rupiah(value);
    };

    // ==========================================
    // TOOLTIP
    // ==========================================

    const createTooltip = () => {
        let tooltip = document.querySelector('.dashboard-chart-tooltip');

        if (!tooltip) {
            tooltip = document.createElement('div');
            tooltip.className = 'dashboard-chart-tooltip';
            document.body.appendChild(tooltip);
        }

        return tooltip;
    };

    const tooltip = createTooltip();

    const showTooltip = (event, html) => {
        tooltip.innerHTML = html;
        tooltip.classList.add('is-visible');

        const x = event.clientX + 14;
        const y = event.clientY - 12;

        const width = tooltip.offsetWidth;
        const height = tooltip.offsetHeight;

        tooltip.style.left = Math.min(
            x,
            window.innerWidth - width - 12
        ) + 'px';

        tooltip.style.top = Math.min(
            Math.max(8, y),
            window.innerHeight - height - 12
        ) + 'px';
    };

    const hideTooltip = () => {
        tooltip.classList.remove('is-visible');
    };

    // ==========================================
    // CANVAS SETUP
    // ==========================================

    const setupCanvas = (canvas) => {
        if (!canvas) return null;

        const rect = canvas.getBoundingClientRect();

        if (!rect.width || !rect.height) return null;

        const ratio = Math.max(
            1,
            window.devicePixelRatio || 1
        );

        canvas.width = Math.round(rect.width * ratio);
        canvas.height = Math.round(rect.height * ratio);

        const context = canvas.getContext('2d');

        context.setTransform(ratio, 0, 0, ratio, 0, 0);

        return {
            context,
            width: rect.width,
            height: rect.height
        };
    };

    // ==========================================
    // DONATION BAR CHART
    // ==========================================

    const donationCanvas = document.getElementById('donationChart');

    let donationBars = [];

    const drawDonationChart = () => {
        if (!donationCanvas || !donationData.length) return;

        const setup = setupCanvas(donationCanvas);

        if (!setup) return;

        const { context: ctx, width, height } = setup;

        ctx.clearRect(0, 0, width, height);

        const padding = {
            top: 15,
            right: 12,
            bottom: 32,
            left: 57
        };

        const chartWidth = width - padding.left - padding.right;
        const chartHeight = height - padding.top - padding.bottom;

        const values = donationData.map(item => Number(item.total) || 0);

        const maxValue = Math.max(...values, 0);

        const axisMax = maxValue > 0
            ? Math.ceil(maxValue * 1.2 / 1000000) * 1000000 || 1000000
            : 1000000;

        const steps = 4;

        ctx.font = '10px Poppins, sans-serif';
        ctx.textAlign = 'right';
        ctx.textBaseline = 'middle';

        // Grid dan label sumbu Y

        for (let i = 0; i <= steps; i++) {
            const value = (axisMax / steps) * i;

            const y = padding.top + chartHeight -
                (chartHeight / steps) * i;

            ctx.beginPath();
            ctx.strokeStyle = '#edf0eb';
            ctx.lineWidth = 1;
            ctx.setLineDash([3, 4]);
            ctx.moveTo(padding.left, y);
            ctx.lineTo(width - padding.right, y);
            ctx.stroke();
            ctx.setLineDash([]);

            ctx.fillStyle = '#9ba198';

            ctx.fillText(
                compactRupiah(value),
                padding.left - 9,
                y
            );
        }

        const count = donationData.length;
        const slotWidth = chartWidth / count;

        const barWidth = Math.min(
            35,
            slotWidth * 0.53
        );

        donationBars = [];

        // Batang grafik

        donationData.forEach((item, index) => {
            const value = Number(item.total) || 0;

            const barHeight = (value / axisMax) * chartHeight;

            const x = padding.left +
                slotWidth * index +
                (slotWidth - barWidth) / 2;

            const y = padding.top +
                chartHeight -
                barHeight;

            const isSelected = Number(item.month_number) ===
                Number(new URLSearchParams(window.location.search).get('month') || new Date().getMonth() + 1)
                && Number(new URLSearchParams(window.location.search).get('year') || new Date().getFullYear()) ===
                Number(new URLSearchParams(window.location.search).get('chart_year') || new Date().getFullYear());

            // Background bar

            const backgroundHeight = chartHeight;

            ctx.fillStyle = '#f3f5f2';

            ctx.beginPath();
            ctx.roundRect(
                x,
                padding.top,
                barWidth,
                backgroundHeight,
                6
            );
            ctx.fill();

            // Bar data

            if (value > 0) {
                const gradient = ctx.createLinearGradient(
                    0,
                    y,
                    0,
                    y + barHeight
                );

                if (isSelected) {
                    gradient.addColorStop(0, '#294236');
                    gradient.addColorStop(1, '#83b84d');
                } else {
                    gradient.addColorStop(0, '#a9ce78');
                    gradient.addColorStop(1, '#83b84d');
                }

                ctx.fillStyle = gradient;

                ctx.beginPath();
                ctx.roundRect(
                    x,
                    y,
                    barWidth,
                    Math.max(barHeight, 3),
                    5
                );
                ctx.fill();
            }

            // Label bulan

            ctx.fillStyle = '#858e84';
            ctx.font = '10px Poppins, sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'top';

            ctx.fillText(
                item.month,
                x + barWidth / 2,
                height - 21
            );

            donationBars.push({
                x,
                y,
                width: barWidth,
                height: Math.max(barHeight, 3),
                value,
                month: item.month,
                monthNumber: item.month_number
            });
        });
    };

    // ==========================================
    // DONATION TOOLTIP
    // ==========================================

    if (donationCanvas) {
        donationCanvas.addEventListener('mousemove', (event) => {
            const rect = donationCanvas.getBoundingClientRect();

            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            const bar = donationBars.find(item => {
                return (
                    x >= item.x - 5 &&
                    x <= item.x + item.width + 5 &&
                    y >= 0 &&
                    y <= rect.height - 20
                );
            });

            if (!bar) {
                hideTooltip();
                return;
            }

            showTooltip(
                event,
                `
                    <div class="chart-tooltip-title">
                        ${bar.month}
                    </div>
                    <div class="chart-tooltip-value">
                        ${rupiah(bar.value)}
                    </div>
                    <div class="chart-tooltip-caption">
                        Donasi terverifikasi
                    </div>
                `
            );
        });

        donationCanvas.addEventListener('mouseleave', hideTooltip);
    }

    // ==========================================
    // CATEGORY DONUT CHART
    // ==========================================

    const categoryCanvas = document.getElementById('categoryChart');

    let donutSegments = [];

    const drawCategoryChart = () => {
        if (!categoryCanvas || !categoryData.length) return;

        const setup = setupCanvas(categoryCanvas);

        if (!setup) return;

        const { context: ctx, width, height } = setup;

        ctx.clearRect(0, 0, width, height);

        const centerX = width / 2;
        const centerY = height / 2;

        const radius = Math.min(width, height) * 0.39;
        const lineWidth = Math.max(15, radius * 0.27);

        const total = categoryData.reduce(
            (sum, item) => sum + Number(item.total || 0),
            0
        );

        donutSegments = [];

        if (!total) return;

        let startAngle = -Math.PI / 2;

        categoryData.forEach(item => {
            const value = Number(item.total) || 0;

            const percentage = value / total;

            const endAngle = startAngle +
                percentage * Math.PI * 2;

            ctx.beginPath();

            ctx.arc(
                centerX,
                centerY,
                radius,
                startAngle,
                endAngle
            );

            ctx.strokeStyle = item.color || '#294236';
            ctx.lineWidth = lineWidth;
            ctx.lineCap = 'butt';
            ctx.stroke();

            donutSegments.push({
                startAngle,
                endAngle,
                name: item.name,
                value,
                percentage: Number(item.percentage)
            });

            startAngle = endAngle;
        });
    };

    // ==========================================
    // DONUT TOOLTIP
    // ==========================================

    if (categoryCanvas) {
        categoryCanvas.addEventListener('mousemove', (event) => {
            const rect = categoryCanvas.getBoundingClientRect();

            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const dx = x - centerX;
            const dy = y - centerY;

            const distance = Math.sqrt(dx * dx + dy * dy);

            const radius = Math.min(rect.width, rect.height) * 0.39;
            const lineWidth = Math.max(15, radius * 0.27);

            const innerRadius = radius - lineWidth / 2;
            const outerRadius = radius + lineWidth / 2;

            if (
                distance < innerRadius ||
                distance > outerRadius
            ) {
                hideTooltip();
                return;
            }

            let angle = Math.atan2(dy, dx);

            if (angle < -Math.PI / 2) {
                angle += Math.PI * 2;
            }

            const segment = donutSegments.find(item => {
                return angle >= item.startAngle &&
                    angle <= item.endAngle;
            });

            if (!segment) {
                hideTooltip();
                return;
            }

            showTooltip(
                event,
                `
                    <div class="chart-tooltip-title">
                        ${segment.name}
                    </div>
                    <div class="chart-tooltip-value">
                        ${rupiah(segment.value)}
                    </div>
                    <div class="chart-tooltip-caption">
                        ${segment.percentage}%
                        dari total donasi
                    </div>
                `
            );
        });

        categoryCanvas.addEventListener('mouseleave', hideTooltip);
    }

    // ==========================================
    // INITIALIZE
    // ==========================================

    const renderCharts = () => {
        drawDonationChart();
        drawCategoryChart();
    };

    renderCharts();

    // Resize chart tanpa library tambahan

    let resizeTimer;

    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(() => {
            renderCharts();
            hideTooltip();
        }, 120);
    });
});
