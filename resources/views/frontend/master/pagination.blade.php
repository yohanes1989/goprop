@if ($paginator->lastPage() > 1)
    <nav class="paginate-custom">
        <ul class="pagination">
            <li class="previous {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                <a href="{{ $paginator->url(1) }}"><i class="fa fa-angle-left"></i></a>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="next {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                <a href="{{ $paginator->url($paginator->currentPage()+1) }}" ><i class="fa fa-angle-right"></i></a>
            </li>
        </ul>
    </nav>
@endif