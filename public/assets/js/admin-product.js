(function () {
    var cfg = window.PRODUCT_FORM_CONFIG;
    if (!cfg) return;

    var brandSelect = document.getElementById('category_id');
    var orientationSelect = document.getElementById('stone_orientation');
    var typeSelect = document.getElementById('stone_type');
    var specPanel = document.getElementById('specSizePanel');
    var specBody = document.getElementById('specSizeBody');
    var nameEn = document.querySelector('[name="name_en"]');
    var selectAll = document.getElementById('selectAllSizes');

    function getTypesForOrientation(orientation) {
        return Object.keys(cfg.stoneTypes).filter(function (key) {
            return cfg.stoneTypes[key].orientation === orientation;
        });
    }

    function fillTypeOptions() {
        var orientation = orientationSelect.value;
        var current = typeSelect.dataset.selected || typeSelect.value;
        typeSelect.innerHTML = '<option value="">— Select stone type —</option>';
        getTypesForOrientation(orientation).forEach(function (key) {
            var t = cfg.stoneTypes[key];
            var opt = document.createElement('option');
            opt.value = key;
            opt.textContent = t.label;
            typeSelect.appendChild(opt);
        });
        if (current) {
            typeSelect.value = current;
            typeSelect.dataset.selected = '';
        }
        renderSpecTable();
    }

    function existingSizeMap() {
        var map = {};
        (cfg.existingSizes || []).forEach(function (s) {
            var key = (s.sl_no || '') + '|' + s.diameter + '|' + (s.bore || '');
            map[key] = s;
        });
        return map;
    }

    function renderSpecTable() {
        var typeKey = typeSelect.value;
        if (!typeKey || !cfg.stoneTypes[typeKey]) {
            specPanel.classList.add('d-none');
            specBody.innerHTML = '';
            return;
        }
        specPanel.classList.remove('d-none');
        var rows = cfg.stoneTypes[typeKey].rows;
        var existing = existingSizeMap();
        specBody.innerHTML = '';

        rows.forEach(function (row, idx) {
            var key = row.sl + '|' + row.diameter + '|' + row.bore;
            var saved = existing[key] || {};
            var checked = (saved.weight || saved.sl_no) ? 'checked' : '';
            var weightVal = (saved.weight || '').replace(/\s*kg\s*/i, '').trim();

            var tr = document.createElement('tr');
            tr.innerHTML =
                '<td><input type="checkbox" class="form-check-input size-enable" name="sizes[' + idx + '][enabled]" value="1" ' + checked + '></td>' +
                '<td>' + row.sl + '<input type="hidden" name="sizes[' + idx + '][sl]" value="' + row.sl + '"></td>' +
                '<td>' + row.diameter + '<input type="hidden" name="sizes[' + idx + '][diameter]" value="' + esc(row.diameter) + '"></td>' +
                '<td>' + row.bore + '<input type="hidden" name="sizes[' + idx + '][bore]" value="' + esc(row.bore) + '"></td>' +
                '<td>' + row.thickness + '<input type="hidden" name="sizes[' + idx + '][thickness]" value="' + esc(row.thickness) + '"></td>' +
                '<td><div class="input-group input-group-sm"><input type="number" step="0.1" min="0" class="form-control size-weight" name="sizes[' + idx + '][weight]" value="' + esc(weightVal) + '" placeholder="kg"><span class="input-group-text">kg</span></div></td>';
            specBody.appendChild(tr);
        });

        suggestProductName();
    }

    function esc(s) {
        return String(s).replace(/"/g, '&quot;');
    }

    function suggestProductName() {
        if (!nameEn || nameEn.value.trim()) return;
        var brand = brandSelect.options[brandSelect.selectedIndex];
        var typeKey = typeSelect.value;
        if (!brand || !typeKey) return;
        var typeLabel = cfg.stoneTypes[typeKey].label.replace(' — ', ' ');
        nameEn.value = brand.text.trim() + ' — ' + typeLabel;
    }

    if (orientationSelect) {
        orientationSelect.addEventListener('change', fillTypeOptions);
    }
    if (typeSelect) {
        typeSelect.addEventListener('change', function () {
            renderSpecTable();
            suggestProductName();
        });
    }
    if (brandSelect) {
        brandSelect.addEventListener('change', suggestProductName);
    }
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.size-enable').forEach(function (cb) {
                cb.checked = selectAll.checked;
            });
        });
    }

    fillTypeOptions();
})();
