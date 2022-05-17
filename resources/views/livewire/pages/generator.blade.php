<div class="w-100 generator d-flex justify-content-center align-items-center">
    <form class="generator__inner">
        <div class="w-100 d-flex flex-column">
            <div class="d-flex justify-content-center">
                <h1 class="generator__title">Генератор ссылок</h1>
            </div>
        </div>

        <div class="w-100 my-2 d-flex flex-column">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" wire:model="longLink" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Ваша ссылка</label>
            </div>
            @error('longLink') <span class="error__link">{{$message}}</span> @enderror
        </div>

        <div class="w-100 my-2">
            <button wire:click.prevent="Generate" class="generator__btn w-100">Создать ссылку</button>
        </div>

        <div wire:loading wire:target="Generate" class="w-100">
            <div class="w-100 d-flex justify-content-center" >
                <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>

        @if($shortLink)
            <div class="w-100 mt-3">
                <div class="generator__result">
                    <div class="qr__code d-flex justify-content-center">

                        {{ \LaravelQRCode\Facades\QRCode::url($shortLink)->setSize(8)->setMargin(2)->svg()}}
                    </div>
                    <div class="generator__result-item">
                        <span>Ваша ссылка готова, она будет активна в течении долгого времени, обновление ссылок проиходит 1 раз в месяц</span>
                        <div class="generator__result-link d-flex mt-2">
                            <textarea id="short__link" class="w-100">{{$shortLink}}</textarea>
                        </div>
                        <div class="generator__result-action">
                            <a href="" wire:click.prevent="copy" data-action="copy" class="generator__result-copy">Копировать</a>
                        </div>
                    </div>
                </div>

                <div class="generator__clear mt-1">
                    <button class="generator__clear-btn" wire:click.prevent="clear">Очистить</button>
                </div>
            </div>

        @endif
    </form>



</div>

@push('scripts')
    <script>
        window.addEventListener('failLink', ()=>{
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                title: 'Недействительная ссылка, или ссылка введена некоректно'
            })
        })
        window.addEventListener('copy', (e) => {
            e.preventDefault()
            const shortLinkBlock = document.querySelector('#short__link');
            shortLinkBlock.select();
            document.execCommand('copy');

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Скопировано!'
            })
        })
    </script>
@endpush
