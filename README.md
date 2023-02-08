
https://user-images.githubusercontent.com/89546855/217533439-6be7a314-6c4f-4bfa-a06e-e59fbfbecd1a.mp4

---

O front end está configurado para fazer requisições na url `http://localhost:8080/api`, então é importante que o projeto esteja rodando na porta 8080 ou que a URL no arquivo `main.js` seja configurada para a porta usada. `php -S localhost:8080` para rodar o servidor.

- Versão do PHP usada: **7.6.29**;
- O bootstrap foi adicionado via CDN e a versão **5.2** foi usada;
- O servidor e o front end da aplicação é totalmente dividida para que o projeto suporte facilmente outras tecnologias e api possa ser usada em qualquer ambiente;
- Para esta aplicação, julguei que a melhor opção para o banco de dados seria o SQLite e assim foi feito. Todos os dados são armazenados no diretório `api/db/database.sqlite`;
- Ao requerir um dado ao servidor, primeiro é feito uma consulta ao banco de dados, caso haja um registro o dado é coletado, tratado e respondido, caso o registro não esteja armazenado, outros métodos são executados para que o dado seja colhido na API do Viacep.com.br via XML, a partir disto os dados são armazenados no banco de dados para uma próxima consulta e o registro também é retornado;
- Poucas linhas de códigos foram usadas para dar vida às interações da aplicação. Com javascript os dados (ou os erros) são exibídos de forma simples, dinâmica e interativa.
