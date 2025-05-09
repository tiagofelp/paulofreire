 	<?php
				require("ses_start.php");
				$RM=$_SESSION['operador'];
			?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Como você tá hoje?</title>
        <style type="text/css">
            @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&display=swap");

            :root {
              --primary: #7c3aed;
              --primary-light: #a78bfa;
              --primary-dark: #6d28d9;
              --secondary: #f5f3ff;
              --text-dark: #1f2937;
              --text-light: #6b7280;
              --success: #10b981;
              --background: #f9fafb;
              --card-bg: #ffffff;
              --border-radius: 16px;
              --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
              --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
              --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            * {
              margin: 0;
              padding: 0;
              box-sizing: border-box;
            }

            body {
              font-family: "Nunito", sans-serif;
             background: radial-gradient(circle, rgba(46, 191, 165, 1) 0%, rgba(78, 65, 135, 1) 100%);
              color: var(--text-dark);
              line-height: 1.6;
              min-height: 100vh;
              display: flex;
              align-items: center;
              justify-content: center;
              padding: 20px;
            }

            .container {
              width: 100%;
              max-width: 650px;
            }

            .card {
              background-color: var(--card-bg);
              border-radius: var(--border-radius);
              box-shadow: var(--shadow-lg);
              overflow: hidden;
              padding: 2rem;
            }

            .header {
              text-align: center;
              margin-bottom: 2rem;
            }

            h1 {
              font-size: 2rem;
              font-weight: 700;
              color: var(--primary-dark);
              margin-bottom: 0.5rem;
            }

            .date {
              font-size: 1rem;
              color: var(--text-light);
              font-weight: 500;
            }

            .emoji-container {
              display: flex;
              justify-content: center;
              gap: 12px;
              margin: 2rem 0;
              flex-wrap: wrap;
            }

            .emoji-option {
              display: flex;
              flex-direction: column;
              align-items: center;
              cursor: pointer;
              transition: all 0.3s ease;
              border-radius: 12px;
              padding: 12px;
              width: 90px;
              position: relative;
              background-color: var(--secondary);
            }

            .emoji-option:hover {
              transform: translateY(-5px);
              box-shadow: var(--shadow);
            }

            .emoji-option:active {
              transform: scale(0.95);
            }

            .emoji {
              font-size: 48px;
              margin-bottom: 8px;
              transition: transform 0.2s ease;
            }

            .emoji-option:hover .emoji {
              transform: scale(1.1);
            }

            .emotion-label {
              font-size: 14px;
              font-weight: 600;
              color: var(--text-light);
              text-align: center;
            }

            .emoji-option.selected {
              background-color: rgba(124, 58, 237, 0.1);
              box-shadow: 0 0 0 2px var(--primary);
            }

            .emoji-option.selected .emotion-label {
              color: var(--primary-dark);
            }

            .input-group {
              margin: 1.5rem 0;
            }

            label {
              display: block;
              font-weight: 600;
              margin-bottom: 0.75rem;
              color: var(--text-dark);
              font-size: 1rem;
            }

            textarea {
              width: 100%;
              padding: 1rem;
              font-size: 1rem;
              border: 2px solid #e5e7eb;
              border-radius: 12px;
              background-color: #f9fafb;
              resize: vertical;
              font-family: "Nunito", sans-serif;
              transition: all 0.3s ease;
            }

            textarea:focus {
              outline: none;
              border-color: var(--primary);
              box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.2);
              background-color: #ffffff;
            }

            textarea::placeholder {
              color: #9ca3af;
            }

            #enviar {
              display: block;
              width: 100%;
              max-width: 250px;
              margin: 2rem auto 0;
              padding: 0.875rem 1.5rem;
              background: linear-gradient(135deg, var(--primary), var(--primary-dark));
              color: white;
              font-weight: 700;
              font-size: 1.125rem;
              border: none;
              border-radius: 30px;
              cursor: pointer;
              transition: all 0.3s ease;
              box-shadow: 0 4px 6px rgba(124, 58, 237, 0.25);
            }

            #enviar:hover {
              transform: translateY(-2px);
              box-shadow: 0 7px 14px rgba(124, 58, 237, 0.3);
            }

            #enviar:active {
              transform: translateY(1px);
            }

            /* Responsive adjustments */
            @media (max-width: 600px) {
              .card {
                padding: 1.5rem;
              }

              h1 {
                font-size: 1.75rem;
              }

              .emoji-container {
                gap: 8px;
              }

              .emoji-option {
                width: 80px;
                padding: 10px;
              }

              .emoji {
                font-size: 40px;
              }

              label {
                font-size: 0.9rem;
              }
            }

            @media (max-width: 400px) {
              .card {
                padding: 1.25rem;
              }

              h1 {
                font-size: 1.5rem;
              }

              .emoji-container {
                gap: 6px;
              }

              .emoji-option {
                width: 70px;
                padding: 8px;
              }

              .emoji {
                font-size: 36px;
              }

              .emotion-label {
                font-size: 12px;
              }

              #enviar {
                font-size: 1rem;
                padding: 0.75rem 1.25rem;
              }
            }

        </style>
        <script type="text/javascript">
            window.onload = function() {
            var emojis = document.getElementsByClassName('emoji-option');
            var inputEmocao = document.getElementById('emocaoSelecionada');

            function selecionarEmoji(event) {
                for (var i = 0; i < emojis.length; i++) {
                    emojis[i].classList.remove('selected');
                }
                event.currentTarget.classList.add('selected');
                var emocaoSelecionada = event.currentTarget.getAttribute('data-emocao');
                inputEmocao.value = emocaoSelecionada;
            }

            for (var i = 0; i < emojis.length; i++) {
                emojis[i].addEventListener('click', selecionarEmoji);
            }
        }

        function validarFormulario() {
			    var inputEmocao = document.getElementById('emocaoSelecionada');
			    var textarea = document.getElementById('texto');

			    var emocaoSelecionada = inputEmocao.value.trim();
			    var textoDigitado = textarea.value.trim();

			    if (!emocaoSelecionada) {
			        alert("Por favor, selecione uma emoção antes de enviar.");
			        return false;
			    }

			    if (textoDigitado.length === 0) {
			        alert("Por favor, escreva algo sobre sua experiência.");
			        return false;
			    }

			    return true;
			}
        </script>
    </head>
    <body>
        <div class="container">
            <div class="card">
                <div class="header">
                    <h1>Qual das emoções abaixo, melhor te representa hoje em relação á Semana Paulo Freire? 😎</h1>
                    <p class="date">Data de Hoje: <strong><?php echo date("d/m/Y"); ?></strong></p>
                </div>

                <form method="POST" action="resultado.php" onsubmit="return validarFormulario()">
                    <input type="hidden" name="emocao" id="emocaoSelecionada">
                    <input type="hidden" name="RM" value="<?php echo($RM); ?>">
                    
                    <div class="emoji-container">
                        <div class="emoji-option" data-emocao="Muito Triste">
                            <div class="emoji">😭</div>
                            <div class="emotion-label">Muito Triste</div>
                        </div>
                        <div class="emoji-option" data-emocao="Triste">
                            <div class="emoji">😔</div>
                            <div class="emotion-label">Triste</div>
                        </div>
                        <div class="emoji-option" data-emocao="Neutro">
                            <div class="emoji">😐</div>
                            <div class="emotion-label">Neutro</div>
                        </div>
                        <div class="emoji-option" data-emocao="Feliz">
                            <div class="emoji">😊</div>
                            <div class="emotion-label">Feliz</div>
                        </div>
                        <div class="emoji-option" data-emocao="Muito Feliz">
                            <div class="emoji">😄</div>
                            <div class="emotion-label">Muito Feliz</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="texto">Escreva detalhes da sua experiência nessa edição da Semana Paulo Freire:</label>
                        <textarea name="texto" id="texto" maxlength="1000" rows="4" placeholder="Compartilhe sua experiência aqui..."></textarea>
                    </div>
                    
                    <button type="submit" id="enviar">Enviar</button>
                </form>
            </div>
        </div>
    </body>
</html>
