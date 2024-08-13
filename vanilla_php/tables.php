<?php
/**
 * Inicializa las tablas y contenido de la base de datos.
 */

require "/var/www/vanilla_php/src/db.php";

$init = <<<SQL
    CREATE TABLE IF NOT EXISTS `post` (
      `id` int PRIMARY KEY AUTO_INCREMENT,
      `title` varchar(80) NOT NULL,
      `content` varchar(2000) NOT NULL,
      `url` varchar(255) DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
    INSERT IGNORE INTO `post` (id, title, content, url, created_at, updated_at) VALUES
    (1,'Recursion','What is recursion?\nRecursion can get difficult to understand. It\'s extremely useful in mathematics and computer science, and can make your programming life easier in a very elegant way (It will also make you look cool...)\n\nRecursion: application of a recursive procedure or definition.\n\nOkay not a really helpful definition. But, in programming, this procedure/definition will be a function.\n\nRecursive function: function that inside its instructions calls itself.\n\nWow that was easy. Well, not always. Let\'s see an example with the function factorial(n) which will calculate the factorial of n. This is the most used recursive function to learn the concept of recursion.\n\ndef factorial(n)\n    return n * factorial(n-1)\n\nWhat does this mean? Well factorial(4) will be 4 * factorial(3). But factorial(3) is called, so it will calculate 4 * 3 * factorial(2). It goes on: 4 * 3 * 2 * 1 * 0 * -1 * -2 * ... wait what? INFINITE RECURSION ALERT\n\nThe function keeps calling itself with lower and lower numbers, so the program never ends and we never get an answer. We know factorials go to 1! = 1, so we can fix the problem with an exit condition:\n\ndef factorial(n)\n    if (n == 1)\n        return 1      \n    return n * factorial(n-1)\n\nthis way, the program flow of factorial(4) will go like this:\n\nreturn 4 * factorial(3)\nreturn 4 * 3 * factorial(2)\nreturn 4 * 3 * 2 factorial(1)\nreturn 4 * 3 * 2 * 1\nreturn 4 * 3 * 2\nreturn 4 * 6\nreturn 25\n\nWith 4 lines of code we can calculate any existing factorial number, we could also use a while loop to do the same thig:\n\ndef factorial(n)\n    num = 1\n    while n >= 1:\n        num = num * n\n        n = n - 1\n    return num:\n\nBut doesn\'t recursion look more cool? you call the function again to do the job for you. Although, there is nothing that can be done with recursion that can\'t be done with loops (source) It\'s more or less efficient depending on the situation.','https://www.linkedin.com/pulse/recursion-salvador-diaz','2024-05-21 22:41:47','2024-05-21 22:41:47'),(2,'What happens when you type google.com in your browser and press Enter?','google.com is a page hosted on a web server. Servers, computers and other devices communicate using IP addresses to identify each other on the internet. Imagine an IP address like a postal address, its purpose is to identify a location to recieve and send packages.\n\nBut the computer doesn\'t know where this name google.com is, it can only locate IP adresses. What is google.com\'s IP? This is where DNS comes in.\n\nDNS request\n\n(Domain Name Service) transaltes domain names (google.com) to their IP Address (8.8.8.8). It first looks in the browser cache file (a temporary storage of information about previous DNS lookups), then in the Operative System\'s cache file.\nIf there\'s still no result the browser sends a request to the Resolver (usually the name server of your internet service provider) to look in its cache. If there\'s still no result, the Resolver sends a request to one of the Root servers, the Root server keeps a list of all the top-level domains (.com, .net, .org, .es, .uk, etc), for example all domains ending in .org are served by the .org TLD. For google.com the root server doesn\'t know the IP address, but it knows which TLD server holds that IP (.com). Then the TLD server provides one of the many authoritative name servers that contain that IP (these are the original and final source) the ANS returns the IP to the Resolver, which saves the IP for future requests and sends it to the browser, who can now communicate with goole.com.\n\nTCP/IP (Transport/Network)\n\nTransport\n\nNetwork\n\nHTTPS/SSL\n\n...\n\nIf the topic interests you you can read more in my Linkedin article. Thank you!','https://www.linkedin.com/pulse/what-happens-when-you-type-googlecom-your-browser-press-salvador-diaz/','2024-05-21 22:44:55','2024-05-21 22:44:55'),(3,'C Compilation','Compiling in C is the process of converting a C script into an executable program that our PC can read and understand. This process is done by a program called the compiler (in this case we are going to use the GCC compiler)\n\nThe compilation process is done in 4 steps: Pre-processing, Compiling, Assembling, and Linking\n\nPre-processing\n\nIt\'s the first step of the process, it removes comments, along with other things. It\'s still C code\n\nCompiling\n\nCompiling is the second step. It takes the output of the preprocessor and generates assembly language, an intermediate human readable language, specific to the target processor (It will most likely not work if you run the same compiled file from another PC).\n\nAssembling\n\nAssembly is the third step of compilation. The assembler will convert the assembly code into pure binary code/machine code/object code (zeros and ones). After this step the code will be saved in a file with the .o suffix\n\nLinking\n\nLinking is the final step of compilation. The linker merges all the object code from multiple modules into a single one. If we are using a function from libraries*, the linker will link our code with that library function code.\n\n*libraries are a collection of pre-built functions that come in very handy with a lot of programs that you will want to make\nUsing the gcc command in linux\n\nIn linux we can use the gcc command to compile C scripts\n# gcc script.c\n\nThis will create the executable file a.out by default, if we wish to give it another name we can use the -o option followed by our desired name\n# gcc script.c -o executable_name','https://www.linkedin.com/pulse/c-compilation-salvador-d-','2024-05-21 22:47:23','2024-05-21 22:47:23');

    CREATE TABLE IF NOT EXISTS `user` (
      `id` int PRIMARY KEY AUTO_INCREMENT,
      `firstname` varchar(255) NOT NULL,
      `lastname` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `img_url` varchar(255) NOT NULL,
      `verified_email` int NOT NULL,
      `google_id` varchar(255) NOT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP
    );
SQL;

DB::connect()->exec($init);
echo "Tablas creadas e inicializadas.\n";
