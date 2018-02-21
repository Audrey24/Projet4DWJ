<div id="tableau">
  <div>
<input class="search col-lg-3" placeholder="RECHERCHE"/>
<button class="sort btn btn-info col-lg-3 offset-lg-1" data-sort="type">Trier par type</button>
<button class="sort btn btn-info col-lg-3 offset-lg-1" data-sort="date">Trier par date</button>
</div></br>

<table class="table">
  <thead class="thead-dark">
      <tr>
        <th class="fuzzy-search" data-sort="id" scope="col">Id</th>
        <th class="fuzzy-search" data-sort="type" scope="col">Type</th>
        <th class="fuzzy-search" data-sort="title" scope="col">Titre</th>
        <th class="fuzzy-search" data-sort="content" scope="col">Contenu</th>
        <th class="fuzzy-search" data-sort="date" scope="col">Publié le</th>
        <th class="fuzzy-search" data-sort="deferred_date" scope="col">Publication différée</th>
        <th class="fuzzy-search" data-sort="edit" scope="col"></th>
        <th class="fuzzy-search" data-sort="delete" scope="col"></th>
      </tr>
    </thead>
    <tbody class="list" id="containList">
    </tbody>
</table>
</div>

<div id="deletemsg"></div>

<?php include("modalDelete.php");?>

<script type="text/javascript" src="lib/js/admin_edit.js"></script>
