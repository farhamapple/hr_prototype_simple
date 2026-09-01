<div class="row g-3">

    <div class="col-md-6">
        <label for="street_address" class="form-label">Alamat</label>
        <input
            id="street_address"
            type="text"
            name="street_address"
            value="{{ old('street_address', $location->street_address ?? '') }}"
            class="form-control @error('street_address') is-invalid @enderror"
            maxlength="40"
        >

        @error('street_address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="postal_code" class="form-label">Kode Pos</label>
        <input
            id="postal_code"
            type="text"
            name="postal_code"
            value="{{ old('postal_code', $location->postal_code ?? '') }}"
            class="form-control @error('postal_code') is-invalid @enderror"
            maxlength="12"
        >

        @error('postal_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="city" class="form-label">
            Kota <span class="text-danger">*</span>
        </label>
        <input
            id="city"
            type="text"
            name="city"
            value="{{ old('city', $location->city ?? '') }}"
            class="form-control @error('city') is-invalid @enderror"
            maxlength="30"
            required
        >

        @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="state_province" class="form-label">Provinsi / State</label>
        <input
            id="state_province"
            type="text"
            name="state_province"
            value="{{ old('state_province', $location->state_province ?? '') }}"
            class="form-control @error('state_province') is-invalid @enderror"
            maxlength="25"
        >

        @error('state_province')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="country_id" class="form-label">Negara</label>
        <select
            id="country_id"
            name="country_id"
            class="form-select @error('country_id') is-invalid @enderror"
        >
            <option value="">Pilih Negara</option>

            @foreach ($countries as $country)
                <option
                    value="{{ $country->country_id }}"
                    @selected(
                        old('country_id', $location->country_id ?? '')
                        == $country->country_id
                    )
                >
                    {{ $country->country_id }} - {{ $country->country_name }}
                </option>
            @endforeach
        </select>

        @error('country_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
