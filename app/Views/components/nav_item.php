 <li class="nav-item">
   <a class="nav-link <?= $uri->getSegment(1) == $segment ? 'active' : null ?>" aria-current="page" href="/<?= $segment ?>"><?= $text ?></a>
 </li>