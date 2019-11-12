@if ($paginator->hasPages())
    <ul class="pagination mb-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
              <a class="page-link py-1" title="No more previous post" style="border-radius: 50px">&larr; Previous</a>
            </li>
        @else
            <li class="page-item">
              <a class="page-link py-1 bg-primary text-light" title="See more previous post" style="border-radius: 50px" href="{{ $paginator->previousPageUrl() }}">&larr; Previous</a>
            </li>
        @endif



        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
          <li class="page-item ml-auto">
            <a class="page-link py-1 bg-primary text-light" title="See more post" style="border-radius: 50px" href="{{ $paginator->nextPageUrl() }}">Next &rarr;</a>
          </li>
        @else
          <li class="page-item ml-auto disabled">
            <a class="page-link py-1" title="No more next post" style="border-radius: 50px;">Next &rarr;</a>
          </li>
        @endif
    </ul>
@endif
