<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Jogo do adivinha</title>
</head>
<body class="h-screen w-screen bg-gray-900 flex items-center flex-col justify-center">
    <div class="p-6 mb-60 w-80 bg-gray-800 border-4 border-yellow-600 rounded-xl shadow-lg flex flex-col items-center justify-center">
        <h1 class="text-xl font-bold text-yellow-500 text-center mb-6">Vamos jogar um jogo de adivinhação!!!</h1>
        
        <form method="POST" class="space-y-4 w-full">
            <button type="submit" name="dificuldade" value="1"class="w-full bg-green-500 hover:bg-green-300 transition-all text-gray-100 text-center py-2 rounded font-semibold cursor-pointer">Fácil</button>

            <button type="submit" name="dificuldade" value="2" class="w-full bg-yellow-500 hover:bg-yellow-300 transition-all text-gray-100 text-center py-2 rounded font-semibold cursor-pointer">Médio</button>

            <button type="submit" name="dificuldade" value="3"class="w-full bg-red-500 hover:bg-red-300 transition-all text-gray-100 text-center py-2 rounded font-semibold cursor-pointer">Difícil</button>
        </form>
    </div>
    <?php
        $dificuldade = null;
        $aleatorio = null;
        $maxtentativa = null;
        $tentativas = 0;
        $mensagem = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dificuldade = $_POST['dificuldade'] ?? null;
            $aleatorio = $_POST['aleatorio'] ?? null;
            $tentativas = $_POST['tentativas'] ?? 0;
            if (!$aleatorio) {
                if ($dificuldade == 1){ $aleatorio = rand(1,10); $maxtentativa = 5; }
                if ($dificuldade == 2){ $aleatorio = rand(1,50); $maxtentativa = 7; }
                if ($dificuldade == 3){ $aleatorio = rand(1,100); $maxtentativa = 10; }
            } else {
                if ($dificuldade == 1) $maxtentativa = 5;
                if ($dificuldade == 2) $maxtentativa = 7;
                if ($dificuldade == 3) $maxtentativa = 10;
            }
            if (isset($_POST['chute'])) {
            $tentativas++;
            $chute = $_POST['chute'];

                if ($chute == $aleatorio) {
                    $mensagem = "🎉 Parabéns, você acertou!";
                } elseif ($tentativas >= $maxtentativa) {
                    $mensagem = "😢 Suas tentativas acabaram! O número era $aleatorio.";
                } elseif ($chute < $aleatorio) {
                    $mensagem = "📉 O número é maior que $chute.";
                } else {
                    $mensagem = "📈 O número é menor que $chute.";
                }
            }
        } 
        if ($dificuldade): 
    ?>
    <div class="p-6 w-screen bg-gray-800 border-4 border-blue-600 rounded-xl shadow-lg text-center text-gray-100">
        <?php if ($dificuldade == 1):?>
            <h2 class="text-2xl font-bold text-green-400 mb-4">Modo Fácil 🎉</h2>
            <p>você tem 5 chances para acertar um número de 1 a 10</p>
        <?php elseif ($dificuldade == 2):?>
            <h2 class="text-2xl font-bold text-yellow-400 mb-4">Modo Médio ⚡</h2>
            <p>você tem 7 chances para acertar um número de 1 a 50</p>
        <?php elseif ($dificuldade == 3):?>
            <h2 class="text-2xl font-bold text-red-500 mb-4">Modo Difícil 🔥</h2>
            <p>você tem 10 chances para acertar um número de 1 a 100</p>
        <?php endif; ?>
        <form method="POST" class="mt-4 flex flex-col items-center space-y-4">
        <input type="number" name="chute" placeholder="Digite seu palpite" class="p-2 bg-gray-100 rounded text-black">
    
        <input type="hidden" name="aleatorio" value="<?php echo $aleatorio; ?>">
        <input type="hidden" name="dificuldade" value="<?php echo $dificuldade; ?>">
        <input type="hidden" name="tentativas" value="<?php echo $tentativas; ?>">


        <button type="submit" name="confirmar" value="ok"class="w-80 bg-yellow-600 hover:bg-yellow-500 transition-all text-gray-100 text-center py-2 rounded font-semibold cursor-pointer">Confirmar</button>
        </form>
        <?php if ($mensagem):?>
            <p class="mt-4 text-lg font-bold text-yellow-400"><?php echo $mensagem; ?></p>
            <?php endif; ?>
    </div>
    <?php endif; ?>
</body>
</html>