<div
    x-data="{ theme: '{{ auth()->user()?->dark_theme ? 'dark' : 'light' }}' }"
    x-init="
        $watch('theme', value => {
            document.body.className = document.body.className
                .replace(/theme-\w+/, `theme-${value}`)

            window.axios.patch('/user', {
                dark_theme: value == 'dark' ? true : false
            })
        })
    "
    class="inline-flex justify-center items-center rounded-full p-2 mr-2 hover:bg-hover transition"
>
    <template x-if="theme === 'light'">
        <button @click="theme = 'dark'">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </button>
    </template>

    <template x-if="theme === 'dark'">
        <button @click="theme = 'light'">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>
    </template>
</div>
