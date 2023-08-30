class Contact:
    def __init__(self, name, phone):
        self.name = name
        self.phone = phone

class ContactManager:
    def __init__(self):
        self.contacts = []

    def add_contact(self, name, phone):
        contact = Contact(name, phone)
        self.contacts.append(contact)
        print(f"Contact '{name}' added successfully!")

    def view_contacts(self):
        if not self.contacts:
            print("No contacts available.")
        else:
            print("Contacts:")
            for index, contact in enumerate(self.contacts, start=1):
                print(f"{index}. Name: {contact.name}, Phone: {contact.phone}")

    def search_contact(self, name):
        found_contacts = [contact for contact in self.contacts if name.lower() in contact.name.lower()]
        if not found_contacts:
            print(f"No contacts found with name '{name}'.")
        else:
            print(f"Found contacts with name '{name}':")
            for contact in found_contacts:
                print(f"Name: {contact.name}, Phone: {contact.phone}")

if __name__ == "__main__":
    manager = ContactManager()

    while True:
        print("\nOptions:")
        print("1. Add Contact")
        print("2. View Contacts")
        print("3. Search Contact")
        print("4. Quit")

        choice = input("Enter your choice: ")

        if choice == "1":
            name = input("Enter name: ")
            phone = input("Enter phone number: ")
            manager.add_contact(name, phone)
        elif choice == "2":
            manager.view_contacts()
        elif choice == "3":
            name = input("Enter name to search: ")
            manager.search_contact(name)
        elif choice == "4":
            print("Exiting the Contact Manager.")
            break
        else:
            print("Invalid choice. Please select a valid option.")
