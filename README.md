# webhook-sender
Sending mechanism to send the webhooks to their destination

## Steps

1. **Clone the repository**:
   ```sh
   git clone <repository-url>
   cd <repository-folder>
    ```

2. Ensure PHP is installed

3. Run the index.php file in the src directory to process and send the webhooks. 

4. Check the logs/logs.log file to check the result.

5. Added tests only for one function Webhook in tests/ folder. Run the tests using the command
    ```sh
        php tests/WebhookTest.php
    ```

## Design decisions:
1. This project follows object oriented approach, organising tasks into separate classes. This makes it easy to scale and maintain.
2. The implementation uses coding principles like single responsibility, DRY, etc.
3. Logging is done extensively to provide debug information. This is useful for monitoring and debugging.
4. Error handling is done in the project to help diagnose problems.

## Security considerations:
1. The project assumes that the webhooks.txt file is correctly formatted. In a production system, it is a good practice to validate and sanitise the input data to prevent the system from any security threats.

## Trade-offs:
1. The system processes the webhooks sequentially. This may not scale well for large number pending webhooks. A more scalable approach would be to use a queue with a few workers to process them.
2. The current design might need sophisticated error handling for different types of HTTP errors or other issues
3. The implementation uses only debug and error level logging. The system might need a more robust logging system.
