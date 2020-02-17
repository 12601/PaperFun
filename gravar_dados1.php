<?php
    //"$conexao" recebe a Conexão com o Banco de Dados
    $conexao = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=rocha123"); // isso faz conexao com o banco, o bdname é o nome do database, user é padrao e a senha é a q a vitoria colocou no pg admin

    if(isset($_POST["inserir"]))
    {
        //"$sql" string para Inser��o de Registros na Tabela
        $sql = "INSERT INTO". '"Produtos"' . "(valor, nome, quantidade) VALUES (". $_POST['valor'] .", '". $_POST['nome'] ."', ". $_POST['quantidade'] .");";

        //"$res" recebe o resultado da Inser��o
        $res = pg_exec($conexao, $sql);

        //"$qtd_linhas" recebe a quantidade de Linhas Afetadas pela Inser��o
        $qtd_linhas = pg_affected_rows($res);

        //Se "$qtd_linhas" tiver um Valor maior que 0 o Produto foi gravado com Sucesso na Tabela
        if ($qtd_linhas > 0)
        {
            echo "Produto Cadastrado com Sucesso";
        }
        //Se "$qtd_linhas" tiver um Valor Igual a 0 é porque ouve um Erro ao gravar o Produto na Tabela
        elseif ($qtd_linhas == 0)
        {
            echo "Não foi possível cadastrar o Produto";
        }
    }

    elseif(isset($_POST["consultar"]))
    {
        echo "PRODUTOS DISPONÍVEIS NO ESTOQUE: <br>";
        //"$sql" string de pesquisa
        $sql = "SELECT * FROM" . '"public" . "Produtos"';
        
        //"$res" recebe o resultado da pesquisa
        $res = pg_exec($conexao, $sql);

        //"$qtd_linhas" recebe a quantidade de Linhas retornadas pela pesquisa
        $qtd_linhas = pg_numrows($res);

       for ($i = 0; $i < $qtd_linhas; $i++)
        {
            $nome = pg_result($res, $i, 0);         //"$nome" é varivel em php recebe o valor  da Coluna "nome" na tabela PRODUTO
            $valor = pg_result($res, $i, 1);       //"$valor" é varivel em php recebe o valor  da Coluna "valor" na tabela PRODUTO
            $quantidade = pg_result($res, $i, 2); //"$quantidade" é varivel em php recebe o valor  da Coluna "quantidade" na tabela PRODUTO

            echo "<br>Nome do produto: ". $nome ."<br>Valor do produto: ". $valor ."<br>Quantidade: ". $quantidade ."<br>"; //Exibe o resultado em uma Tabela
        }   
    }

    else if(isset($_POST["deletar"]))
    {
        echo "Produtos deletados com sucesso";

        //"$sql" string de pesquisa
        $sql = "DELETE FROM" . '"public" . "Produtos"'; // não fizemos para apagar só um produto, essa função apaga a tabela toda
        $res = pg_exec($conexao, $sql); // res é uma variavel que esta pegando o valor do banco e mostrando , pega as informaçoes da tabela, e o que faz essa conexao é o pg exec
        $qtd_linhas = pg_numrows($res);  //"$qtd_linhas" recebe a quantidade de Linhas retornadas pela pesquisa


    }

?>