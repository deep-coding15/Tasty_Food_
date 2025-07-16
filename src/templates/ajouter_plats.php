<?php $title = "Ajout d'une recette !"; ?>

<?php ob_start(); ?>

<div class=" flex flex-col items-center justify-center min-h-screen mt-6 mb-36">

  <form action="add_receipe" class="bg-gray-300 p-8 mt-16 mb-24 rounded-3xl shadow-2xl w-fit max-w-md space-y-6 flex-grow" method="post">
    <h2 class="text-3xl font-bold text-center text-green-500">Ajoutez un plat !</h2>
    <div>
      <label for="name_plat" class="block text-sm font-medium text-black-300">Nom du plat : </label>
      <input type="text" name="name_plat" id="name_plat" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div>
      <label for="description" class="text-black-300">Description du plat : </label>
      <br/>
      <textarea name="description" id="description" cols="50" rows="10" class="bg-gray-200 border-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"></textarea>
    </div>
    <div>
      <label for="image_plat" class="block text-sm font-medium text-black-300 mb-1">
        Image du plat : 
      </label>
      <input
        type="file"
        name="image_plat"
        id="image_plat"
        accept="image/*"
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
              text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
              file:rounded-2xl file:border-1 file:text-sm file:font-semibold
              file:bg-blue-50 file:text-blue-700
              hover:file:bg-blue-100
              focus:outline-none focus:ring-2 focus:ring-blue-500"
        required
      />
    </div>
    <div>
      <label for="prix_plat" class="text-black-300">Prix du plat : </label>
      <br>
      <input type="number" name="prix_plat" id="prix_plat" class="bg-gray-200 rounded-lg p-2 w-full">
    </div>
    <div>
      <label for="name" class="block text-sm font-medium text-black-300">Type du plat : </label>
      <select name="type_plat" id="type_plat" required class="border rounded-lg text-gray-800 p-2 bg-gray-100 w-full text-center">
        <option value="" name="type_plat">--Selectionner un type de plat--</option>
        <option value="entree" name="type_plat">Plat d'entrée</option>
        <option value="resistance" name="type_plat">Plat de résistance</option>
        <option value="accompagnement" name="type_plat">Accompagnements</option>
        <option value="dessert" name="type_plat">Dessert</option>
      </select>
    </div>
  
    <div class="flex justify-center">
      <button class="bg-blue-600 text-white font-medium py-2 px-4 rounded
                transition duration-300 ease-in-out
                hover:bg-blue-700 hover:scale-105 
                hover:opacity-90 block justify-center">
        Réserver maintenant
      </button>
    </div>
    

  </form>
</div>
<?php $content = ob_get_clean(); ?>

<?php require 'layout.php'; ?>
