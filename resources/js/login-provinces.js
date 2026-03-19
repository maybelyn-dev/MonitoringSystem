async function loadRegion3Provinces() {
    const select = document.querySelector('#province_id');
    const loading = document.querySelector('#province-loading');
    const error = document.querySelector('#province-error');
    const appConfig = window.appConfig || {};
    const baseUrlMeta = document.head.querySelector('meta[name="app-base-url"]');
    const csrfTokenMeta = document.head.querySelector('meta[name="csrf-token"]');
    const baseUrl = appConfig.baseUrl || baseUrlMeta?.content || '';
    const csrfToken = appConfig.csrfToken || csrfTokenMeta?.content || '';
    const apiUrl = appConfig.routes?.region3Provinces
        || (baseUrl
            ? `${baseUrl.replace(/\/$/, '')}/api/provinces/region-3`
            : '/api/provinces/region-3');

    if (!select) {
        return;
    }

    try {
        const res = await fetch(apiUrl, {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
            },
        });
        if (!res.ok) {
            throw new Error('API request failed');
        }
        const data = await res.json();
        if (!data?.provinces?.length) {
            throw new Error('No provinces returned');
        }

        const selectedValue = select.value;
        select.innerHTML = '<option value="">-- Choose a province --</option>';
        data.provinces.forEach((province) => {
            const option = document.createElement('option');
            option.value = province.id;
            option.textContent = province.name;
            if (String(province.id) === String(selectedValue)) {
                option.selected = true;
            }
            select.appendChild(option);
        });
        loading?.classList.add('hidden');
    } catch (err) {
        console.error('Could not load Region III provinces API:', err);
        loading?.classList.add('hidden');
        error?.classList.remove('hidden');
    }
}

window.addEventListener('DOMContentLoaded', loadRegion3Provinces);
