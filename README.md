
## Pet Clicker API

#### Project Setup
- Create a .env file and copy everything from .env.example into the .env file
- Create an S3 bucket on AWS and set the following variables in the .env file: <br>
        ` AWS_ACCESS_KEY_ID={{your aws access key id}}` <br>
        ` AWS_SECRET_ACCESS_KEY={{your aws access key}}` <br>
        ` AWS_DEFAULT_REGION={{aws region}}` <br>
        ` AWS_BUCKET={{S3 bucket name}}` <br>
        ` AWS_URL={{S3 bucket url}}` <br>
        
 - Run `docker-compose up -d --build`
 - Run `docker exec -it pet-clicker-api bash`
 - Now inside the container, run `php artisan migrate`
 
 - The app should now be running on `localhost:8084`


#### User Auth Routes
 - Registration <br>
    - url: `{{app_url}}/api/auth/register`
    - required fields: <br>
        `name` <br>
        `email` <br>
        `password` <br>
        `password_confirmation` <Br>
 - Login <br>
    - url: `{{app_url}}/api/auth/login
    - required fields: <br>
        `email`<br>
        `password`
    
 - Logout <br>
    - url: `{{app_url}}/api/auth/logout`
    required fields: NONE
       

