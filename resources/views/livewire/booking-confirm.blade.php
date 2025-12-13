<div>
    <section class="section-container">
        <aside>
            Departure Address: {{ $this->departureAddress->name }} <br>
            Arrival Address: {{ $this->arrivalAddress->name }} <br>
            Departure Time: {{ $this->departureTime }} <br>
            Arrival Time: {{ $this->arrivalTime }} <br>
        </aside>
        <aside>
            <x-checkbox id="rounded-md" wire:click="$refresh" wire:model.live="directDropoff" rounded="md" label="Direct Dropoff(R{{ $this->directDropoffPrice }}) - Only applicable if you stay in Hillcrest or Hatfield" value="md" xl />
            <x-checkbox id="rounded-md" wire:click="$refresh" wire:model.live="wifi" rounded="md" label="Uncapped wifi(R{{ $this->wifiPrice }})" value="md" xl />
            Price: R{{ $this->price }}
        </aside>
    </section>
</div>
