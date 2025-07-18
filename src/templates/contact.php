<?php
$title = 'Tasty Food - Contact';
require_once __DIR__ .'/../../config/database.php';
ob_start();
?>
<section class="w-4/6 mx-auto mb-12">
    
  <div class="flex flex-col items-center justify-center m-12 w-full">
    <h1 class="text-center text-2xl font-medium text-gray-800 mb-6">Contactez - nous</h1>
    <form action="" method="post"
      class="bg-gray-300 p-8 rounded-3xl shadow-2xl w-full max-w-md space-y-6 transition duration-500 ease-out hover:scale-105
      flex flex-col justify-center">
      
      <div>
        <label for="name" class="block text-center w-full">Name:</label>
        <input type="text" name="name" id="name" required
          class="rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>

      <div>
        <label for="email" class="block text-center w-full">Email:</label>
        <input type="email" name="email" id="email"
          class="rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>

      <div>
        <label for="message" class="block text-center w-full">Message:</label>
        <textarea name="message" id="message" rows="6" required
          placeholder="Écrire votre message..."
          class="rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
      </div>

      <button type="submit"
        class="bg-blue-600 text-white font-medium py-2 px-6 rounded transition hover:duration-700
            hover:ease-in-out hover:bg-blue-700 hover:scale-110 hover:opacity-90 block w-lg">
        ENVOYER
      </button>
    </form>
  </div>
</section>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ .'/layout.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postData = $_POST;

    if(
        isset($postData['name']) && trim($postData['name']) != ''
        && isset($postData['email']) && trim($postData['email']) != ''
        && isset($postData['message']) && trim($postData['message']) != ''
    ) {
        $name = $postData['name'];
        $email = $postData['email'];
        $message = $postData['message'];

        $sql = "INSERT INTO contact(name_user, email, message) VALUES (:name, :email, :message)";
        
        $resultStatus = (new Database())->executeSqlStatement($sql, [
              ":name"=> $name,
              ":email"=> $email,
              ":message"=> $message
          ]
        );
        /* $pdo = $database->getConnection();
 */
        /* $statement = $d $pdo->prepare($sql);
        $resultStatus = $statement->execute();
 */
        if($resultStatus) {
            echo "Le message a été enregistré avec succès";
        } else {
            echo "Le message n'a pas été enregistré";
        }
    }
}