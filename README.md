# PHP API Based on the MVC Model (Without View)

## Description

This API was developed as part of our PHP course. It follows the MVC model, although the "View" part is absent, with a focus solely on the Controller and Model. The API allows for CRUD (Create, Read, Update, Delete) operations on a specific resource.

## Features

The API supports the following operations:

- **GET /resource**: Retrieves all items of the resource.
- **GET /resource/{id}**: Retrieves a specific item using its `id`.
- **POST /resource**: Creates a new item for the resource.
- **PUT /resource/{id}**: Updates an existing item based on its `id`.
- **DELETE /resource/{id}**: Deletes a specific item using its `id`.

## Project Structure

The project follows an MVC architecture:

- **Model**: Contains the application logic, particularly interactions with the database.
- **Controller**: Handles HTTP requests and sends appropriate responses.
- **No View**: This API does not include a view, as it is intended for direct use by clients (such as a frontend or another service).
