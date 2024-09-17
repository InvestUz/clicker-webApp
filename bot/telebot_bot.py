import telebot
import requests

API_TOKEN = 'YOUR_TELEGRAM_BOT_API_TOKEN'
bot = telebot.TeleBot(API_TOKEN)

# Start command handler
@bot.message_handler(commands=['start'])
def send_welcome(message):
    bot.reply_to(message, "Welcome to Tap Pizza! Tap the button below to earn pizza slices 🍕. Use /leaderboard to see the top players.")

# Tap command handler
@bot.message_handler(commands=['tap'])
def send_pizza(message):
    user_id = message.from_user.id
    username = message.from_user.username
    url = f"http://your-backend-url.com/backend/tap.php?user_id={user_id}&username={username}"
    response = requests.get(url)
    
    if response.status_code == 200:
        data = response.json()
        earnings = data.get('earnings', 0)
        bot.reply_to(message, f"🍕 You earned more slices! Total pizza slices: {earnings}")
    else:
        bot.reply_to(message, "Something went wrong, try again!")

# Leaderboard command handler
@bot.message_handler(commands=['leaderboard'])
def leaderboard(message):
    url = "http://your-backend-url.com/backend/leaderboard.php"
    response = requests.get(url)
    
    if response.status_code == 200:
        leaderboard_data = response.json()
        leaderboard_text = "\n".join([f"{i+1}. {user['username']}: {user['earnings']} 🍕" for i, user in enumerate(leaderboard_data)])
        bot.reply_to(message, f"🏆 Pizza Tap Leaderboard 🏆\n\n{leaderboard_text}")
    else:
        bot.reply_to(message, "Error fetching leaderboard, try again later.")

bot.polling()
