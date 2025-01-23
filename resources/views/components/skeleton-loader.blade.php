@for ($i = 0; $i < $count; $i++)
    @if ($type == 'card')
        <div class="skeleton skeleton-card"></div>
    @elseif ($type == 'div')
        <div class="skeleton skeleton-div"></div>
    @elseif ($type == 'span')
        <span class="skeleton skeleton-span"></span>
    @endif
@endfor

<style>
    body.light .skeleton {
        background: linear-gradient(90deg, var(--light-skeleton-primary) 25%, var(--light-skeleton-secondary) 50%, var(--light-skeleton-primary) 75%);
        background-size: 200% 100%;
        animation: skeleton-loading 1.5s infinite;
        border-radius: 5px;
    }
    body.dark .skeleton {
        background: linear-gradient(90deg, var(--dark-skeleton-primary) 25%, var(--dark-skeleton-secondary) 50%, var(--dark-skeleton-primary) 75%);
        background-size: 200% 100%;
        animation: skeleton-loading 1.5s infinite;
        border-radius: 5px;
    }

    .skeleton-card {
        width: 100%;
        height: 250px;
        margin-bottom: 20px;
    }

    .skeleton-div {
        width: 100%;
        height: 16rem;
        margin-bottom: 10px;
    }

    .skeleton-span {
        display: inline-block;
        width: 150px;
        height: 20px;
    }

    @keyframes skeleton-loading {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
</style>
